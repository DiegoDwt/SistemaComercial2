<?php
include 'banco.php';

// Obtém o ID do cliente a partir da URL
$id = $_POST['id'];

// Conecta ao banco de dados
$client = Banco::conectar();
$database = Banco::getDatabase();
$collection = $database->Clientes;

// Realiza a exclusão do registro
$result = $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

// Verifica se a exclusão foi bem-sucedida
if ($result->getDeletedCount()) {
    // Redireciona para a mesma página após a exclusão
    header("Location: clientes.php");
    exit;
} else {
    // Em caso de falha na exclusão, retorna um erro
    echo 'error';
}
?>
