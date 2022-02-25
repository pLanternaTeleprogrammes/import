<?php
echo "\n#####IMPORT USER#####\n\n";


$tNewOldTables = [
    'user' => 'np_sonatauser_user'
];

$tUser = [
    ['id' => 'id'],
    'username',
    'roles',
    'password',
    'email',
    ['enable' => 'enabled'],
    'last_login',
    'locked',
    'expired',
    'created_at',
    'updated_at',
    'date_of_birth',
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
    'ip_must_be_controlled_user',
    'auth_code_user',
];

foreach($tNewOldTables as $sNewTable => $sOldTable ) {
    $sNewOldFieldsArrayName = 't' . ucfirst($sNewTable);
    $o = new import\Class\Import($sNewTable, $sOldTable, ${$sNewOldFieldsArrayName});
    //echo "1";
    //$o->truncateNewTable();
    //echo "2";
    $o->setOldDatas();
    //echo "3";
    //var_export($o->getOldDatas());
    $o->insert();
}
