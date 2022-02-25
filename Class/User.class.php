<?php
namespace import\Class;

use import\Class\Import;

class User extends Import
{
    protected $newFieldsOldFields = [
        ['id' => 'id'],
        'username',
        'roles',
        'password',
        'email',
        'enable',
        'last_login',
        'locked',
        'expired',
        'created_at',
        'updated_at',
        'date_of_birthday',
        'firstname',
        'lastname',
        'gender',
        'locale',
        'timezone',
        'phone',
        'type',
        'username_canonical',
        'email_canonical',
        'ip_user',
        'ip_must_be_controlled',
        'auth_code_user',
    ];
    protected $sOldTable = 'np_sonatauser_user';
    protected $sNewTable = 'user';

    public function __construct(ImportPdo $oNpv3Pdo, ImportPdo $oKbPdo)
    {
        $this->oNpv3Pdo = $oNpv3Pdo;
        $this->oKbPdo = $oKbPdo;

        parent::setOldFieldAndNewField();

        $this->tOldDatas = parent::getOldDatas();
        var_export($this->tOldDatas);
    }

}
