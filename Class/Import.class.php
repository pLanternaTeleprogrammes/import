<?php
namespace import\Class;

use import\Class\KbPdo as KbPdo;
use import\Class\Npv3Pdo as Npv3Pdo;

/**
* p.lanterna 25/02/22
* @class cette classe permet de faire des imports entre netpressev3 vers koalaBackend
*/
class Import
{
    //connecteurs aux bdds
    protected $oNpv3Pdo;
    protected $oKbPdo;
    //nom des tables
    protected $sNewTable = null;
    protected $sOldTable = null;
    //champs
    protected $tNewFieldsOldFields = [];
    protected $tNewFields = [];
    protected $tOldFields = [];
    //valeurs à importer
    protected $tOldDatas = [];
    //parametres pour la requete d'insert
    protected $tParametersInsert = [];

    /**
    * @var string $sNewTable le nom de la nouvelle table
    * @var string $sOldTable le nom de l'ancienne table
    * @var array/null $tNewFieldsOldFields le tableau de correspondance des champs
    *                   - laisser null ou tablea vide si les champs sont exactements les mêmes entre les 2 tables
    *                   - si certains champs sont sélectionnés et garde le même nom, mettre le nom
    *                   - si certains champs change de nom faire une association [nouveauChamp => vieuxChamp]
    */
    public function __construct(string $sNewTable, string $sOldTable, ?array $tNewFieldsOldFields)
    {
        $this->oKbPdo = KbPdo::get(KB_DSN, KB_USER, KB_PASS);
        $this->oNpv3Pdo = Npv3Pdo::get(NPV3_DSN, NPV3_USER, NPV3_PASS);
        $this->sNewTable = $sNewTable;
        $this->sOldTable = $sOldTable;
        $this->tNewFieldsOldFields = $tNewFieldsOldFields;
        $this->tOldDatas = $this->getOldDatas();
        $this->setOldFieldAndNewField();
    }

    /**
     * récupération des données depuis netpressev3
     * @var string $sCondition pour ajouter un where par exemple
     */
    public function setOldDatas(?string $sCondition = '') :void
    {
        $query = <<<SQL
SELECT * FROM {$this->sOldTable}
{$sCondition}
SQL;
        $sth = $this->oNpv3Pdo->query($query);
        $sth->execute();
        $this->tOldDatas = $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOldDatas() :array
    {
        return $this->tOldDatas;
    }

    /**
     * remplissage des tableaux de champs
     */
    public function setOldFieldAndNewField() :void
    {
        if(!empty($this->tNewFieldsOldFields)) {
            foreach($this->tNewFieldsOldFields as $xField){
                //si la valeur est un array
                // couple clé => valeur avec nouveau champs => vieux champs
                if(is_array($xField)){
                    $this->tNewFields[] = array_key_first($xField);
                    $this->tOldFields[] = array_shift($xField);

                //sinon le champs a le meme nom
                } else {
                    $this->tOldFields[] = $this->tNewFields[] = $xField;
                }
            }
        }
    }

    public function insert()
    {
        $sFieldsToInsert = $this->_getFieldsToInsert();
        $sParametersToInsert = $this->_getParametersToInsert();
        //parcours toutes les lignes récupérées de l'ancienne table
        foreach ($this->tOldDatas as $tLine) {
            $query = <<<SQL
INSERT INTO {$this->sNewTable}
({$sFieldsToInsert})
VALUES
({$sParametersToInsert})
SQL;
            $tParameters = [];
            //créé le tableau associatif de paramètres pour la requete
            foreach($this->tParametersInsert as $sParameter => $sField){
                $tParameters[$sParameter] = $tLine[$sField];
            }
            $sth = $this->oKbPdo->prepare($query);
            
            var_export($query);
            var_export($tParameters);
            //*/
            $sth->execute($tParameters);
        }
    }

    public function truncateNewTable() :void
    {
        /*
        $query = <<<SQL
TRUNCATE TABLE {$this->sNewTable};
SQL;
//*/
        $sth = $this->oKbPdo->query($query);
        $sth->execute();
        //*/
    }

    /*
     *créer la liste des champs sur la nouvelle table pour la requete d'insert
    */
    private function _getFieldsToInsert()
    {
        return implode(',',$this->tNewFields);
    }

    /**
     * créer la liste des paramètres pour le insert dans la nouvelle table
     */
    private function _getParametersToInsert()
    {
        $this->tParametersInsert = [];
        $tParameters = [];
        foreach($this->tOldFields as $k => $v){
            $tParameters[$k] = ':' . $v;
            $this->tParametersInsert[':' . $v] = $v;
        }
        return implode(',', $tParameters);
    }
}
