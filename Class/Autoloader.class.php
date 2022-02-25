<?php
namespace import\Class;

class Autoloader
{
    public static function register() :void
    {
        \spl_autoload_register([__CLASS__, 'autoload']);
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    static function autoload($class) :void
    {
        $class = str_replace(__NAMESPACE__. '\\','',$class);
        $class = str_replace('\\','/',$class);
        if(file_exists(__DIR__ . '/' . $class . '.class.php'))
        {
            require __DIR__ . '/' . $class . '.class.php';
        }
    }
}
