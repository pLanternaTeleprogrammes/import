<?php
namespace import\Class;

use import\Class\ImportPdo;

class Npv3Pdo extends ImportPdo
{
    protected static $_instance = null;
    protected $_instancePdo = null;
    
    protected function __construct(string $dsn, string $username, string $password, ?array $driverOptions = null)
    {
        $this->_instancePdo = new \PDO($dsn, $username, $password, $driverOptions);
    }

    public static function get(string $dsn, string $username, string $password, ?array $driverOptions = null) :self
    {
        if(is_null(self::$_instance)) {
            self::$_instance = new Npv3Pdo($dsn, $username, $password, $driverOptions);
        }

        return self::$_instance;
    }
}
