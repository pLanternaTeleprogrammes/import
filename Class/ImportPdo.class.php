<?php
namespace import\Class;

class ImportPdo /*extends \PDO //*/
{
    protected static $_instance = null;
    protected $_instancePdo = null;

    public function query($query) :\PDOStatement
    {
        return $this->_instancePdo->query($query);
    }

    public function prepare($query) :\PDOStatement
    {
        return $this->_instancePdo->prepare($query);
    }
}
