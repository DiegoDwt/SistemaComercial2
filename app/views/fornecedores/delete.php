<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../../index.php");
    exit;
}

// Verifica o token CSRF
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Verifica se o ID do fornecedor foi enviado
if (!isset($_POST['id']) || empty($_POST['id'])) {
    die('ID do fornecedor não fornecido');
}

// Inclui o arquivo de configuração do banco de dados e a classe Fornecedor
require_once '../../../core/banco.php';
require_once '../../../app/models/Fornecedor.php';

use Core\Banco;

$client = Banco::conectar();
if (!$client) {
    die("Erro ao conectar ao banco de dados");
}

$database = Banco::getDatabase();
$collection = $database->Fornecedores;

// Deleta o fornecedor
$id = $_POST['id'];
$result = $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

if ($result->getDeletedCount() === 1) {
    echo "Fornecedor excluído com sucesso!";
    header("location: ../../../fornecedores.php");
    exit;
} else {
    echo "Erro ao excluir fornecedor.";
}

// Fecha a conexão com o banco de dados
Banco::desconectar();
?>
