<?php

require_once 'vendor/autoload.php'; // Certifique-se de incluir o autoload da sua biblioteca MongoDB

use MongoDB\Client;

class Banco
{
    private static $client = null;
    private static $dbHost = 'localhost';
    private static $dbPort = '27017';
    private static $dbName = 'Agenda';

    public function __construct() 
    {
        die('A função Init não é permitida!');
    }

    public static function conectar()
    {
        if (self::$client === null)
        {
            try
            {
                self::$client = new Client("mongodb://" . self::$dbHost . ":" . self::$dbPort);
            }
            catch (Exception $exception)
            {
                die($exception->getMessage());
            }
        }
        return self::$client;
    }

    public static function desconectar()
    {
        self::$client = null;
    }

    public static function getDatabase()
    {
        return self::conectar()->selectDatabase(self::$dbName);
    }
}
?>
