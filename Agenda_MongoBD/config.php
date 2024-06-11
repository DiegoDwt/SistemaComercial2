<?php

require 'vendor/autoload.php'; // Certifique-se de ter o Composer instalado e configurado

/* Configurações do MongoDB */
define('MONGO_HOST', 'localhost');
define('MONGO_PORT', '27017');
define('MONGO_DBNAME', 'Agenda');

/* Tentativa de conexão com o MongoDB */
try {
    $client = new MongoDB\Client("mongodb://" . MONGO_HOST . ":" . MONGO_PORT);
    $database = $client->selectDatabase(MONGO_DBNAME);
} catch (Exception $e) {
    die("ERROR: Não foi possível conectar ao MongoDB. " . $e->getMessage());
}
?>
