<?php

namespace App\Models;

session_start();

use App\Controllers\ClienteController;
use App\Models\Cliente;
use Core\Banco;

// Verifica se o usuário está logado
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

// Inclui o autoload do Composer e o arquivo de configuração do Monolog
require 'vendor/autoload.php';
$log = require 'config/log.php';

// Adiciona um log informando que o usuário está acessando a página de clientes
$log->info('Usuário acessou a página de clientes.', ['username' => $_SESSION['username'] ?? 'unknown']);

// Inclui o arquivo de configuração do banco de dados e as classes necessárias
require_once 'core/banco.php';
require_once 'app/models/Cliente.php';
require_once __DIR__ . '/app/Controllers/ClientesController.php';


// Conecta ao banco de dados
$client = Banco::conectar();
if (!$client) {
    $log->error('Erro ao conectar ao banco de dados.');
    die("Erro ao conectar ao banco de dados");
}
$log->info('Conectado ao banco de dados com sucesso.');

$database = Banco::getDatabase();
$collection = $database->Clientes;

// Função para converter documentos do MongoDB em objetos Cliente
function convertDocumentToCliente($doc) {
    return new Cliente(
        htmlspecialchars($doc['nome']),
        htmlspecialchars($doc['cpf']),
        htmlspecialchars($doc['endereco']),
        htmlspecialchars($doc['telefone']),
        htmlspecialchars($doc['email']),
        htmlspecialchars($doc['sexo']),
        (string) $doc['_id']
    );
}

// Verifica se foi enviada uma requisição POST para excluir um cliente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $clienteController = new ClienteController($log);
    $clienteController->delete($_POST['id']);
}

// Busca documentos na coleção de clientes
$clientes = [];
foreach ($collection->find([], ['sort' => ['_id' => 1], 'limit' => 100]) as $doc) {
    $clientes[] = convertDocumentToCliente($doc);
}

// Fecha a conexão com o banco de dados
Banco::desconectar();
$log->info('Desconectado do banco de dados.');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Clientes</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="jumbotron bg-primary">
            <div class="row text-white">
                <h1 class="font-weight-bold">SISTEMA DE CADASTROS</h1>
                <h3><span class="badge bg-primary"> Versão 2.0</span></h3>
            </div>
        </div>
        
        <div class="card-header container text-center">
            <h2 class="font-weight-bold bg-primary text-white"> Clientes </h2>
            <div class="text-center">
                <p>
                    <a href="app/views/clientes/create.php" class="btn btn-success">Adicionar</a>
                </p>
            </div>
            
            <table class="table table-striped container">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nome</th>
                        <th scope="col">CPF</th>
                        <th scope="col">Endereço</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">Email</th>
                        <th scope="col">Sexo</th>
                        <th scope="col">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cliente->getId()); ?></td>
                            <td><?php echo htmlspecialchars($cliente->getNome()); ?></td>
                            <td><?php echo htmlspecialchars($cliente->getCpf()); ?></td>
                            <td><?php echo htmlspecialchars($cliente->getEndereco()); ?></td>
                            <td><?php echo htmlspecialchars($cliente->getTelefone()); ?></td>
                            <td><?php echo htmlspecialchars($cliente->getEmail()); ?></td>
                            <td><?php echo htmlspecialchars($cliente->getSexo()); ?></td>
                            <td width="250">
                                <a class="btn btn-primary" href="app/views/clientes/read.php?id=<?php echo urlencode($cliente->getId()); ?>">Info</a>
                                <a class="btn btn-warning" href="app/views/clientes/update.php?id=<?php echo urlencode($cliente->getId()); ?>">Atualizar</a>
                                
                                <!-- Botão Excluir com JavaScript -->
                                <a id="deleteBtn<?php echo htmlspecialchars($cliente->getId()); ?>" class="btn btn-danger delete-btn" href="#">Excluir</a>
                                
                                <!-- Formulário de Exclusão (oculto) -->
                                <form id="deleteForm<?php echo htmlspecialchars($cliente->getId()); ?>" action="clientes.php" method="post" style="display:none;">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($cliente->getId()); ?>">
                                    <!-- Adicionando um token CSRF -->
                                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="text-center">
            <a href="welcome.php" class="btn btn-primary">Voltar</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.delete-btn').click(function(e) {
                e.preventDefault(); // Impede o comportamento padrão do link

                var btnId = $(this).attr('id'); // Obtém o ID do botão
                var formId = btnId.replace('deleteBtn', 'deleteForm'); // Calcula o ID do formulário correspondente

                if (confirm('Tem certeza que deseja excluir este cliente?')) {
                    $('#' + formId).submit(); // Envia o formulário
                }
            });
        });
    </script>
</body>
</html>
