<?php
## BDD netpressev3 ou on a les infos
define('NPV3_HOST',   'kb-mysql');
define('NPV3_DBNAME', 'netpressev3');
define('NPV3_USER',   'root');
define('NPV3_PASS',   'root');
define('NPV3_DSN',    'mysql:host=' . NPV3_HOST . ';dbname=' . NPV3_DBNAME);

## fin BDD netpressev3
## BDD koalaBackend ou on met les infos
define('KB_HOST',   'kb-mysql');
define('KB_DBNAME', 'koalaBackend');
define('KB_USER',   'kb');
define('KB_PASS',   'kbpass');
define('KB_DSN',    'mysql:host=' . KB_HOST . ';dbname=' . KB_DBNAME);
## fin BDD koalaBackend

$tToImport = [
    'User' => true,
];
