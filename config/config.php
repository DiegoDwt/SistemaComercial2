<?php

// Incluir o autoload do Composer para carregar automaticamente as classes
require_once __DIR__ . '../../vendor/autoload.php';


// Configurações do MongoDB
define('MONGO_HOST', 'localhost');
define('MONGO_PORT', '27017');
define('MONGO_DBNAME', 'Agenda');

// Função para conectar ao MongoDB
function connectMongoDB()
{
    try {
        $client = new MongoDB\Client("mongodb://" . MONGO_HOST . ":" . MONGO_PORT);
        $database = $client->selectDatabase(MONGO_DBNAME);
        return $database;
    } catch (Exception $e) {
        die("ERROR: Não foi possível conectar ao MongoDB. " . $e->getMessage());
    }
}

?>
