<?php
echo "debut import.php\n\n";
require 'importConfig.php';
require_once __DIR__ . '/Class/Autoloader.class.php';
import\Class\Autoloader::register();

$oKbPdo = import\Class\KbPdo::get(KB_DSN,KB_USER,KB_PASS);
$oNpv3Pdo = import\Class\Npv3Pdo::get(NPV3_DSN, NPV3_USER, NPV3_PASS);

foreach ($tToImport as $class => $bToImport){
    
    if($bToImport){
        include __DIR__ . '/' . strtolower($class) . '/import' . $class . '.php';
    }
}


echo "fin import.php\n\n";
