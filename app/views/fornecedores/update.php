<?php
session_start();

use App\Controllers\FornecedorController;
use Core\Banco;

require __DIR__ . '/../../../vendor/autoload.php';
$log = require __DIR__ . '/../../../config/log.php';
require_once __DIR__ . '/../../../app/controllers/FornecedorController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
    $fornecedorController = new FornecedorController($log);
    $fornecedorController->update($_GET['id']);
    
    // Redireciona para a página de fornecedores após a atualização
    header("Location: ../../../fornecedores.php");
    exit;
}

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../../assets/css/bootstrap.min.css">
    <title>Atualizar Fornecedor</title>
</head>
<body>
    <div class="container col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
        <div class="jumbotron bg-primary">
            <div class="row text-white">
                <h1 class="font-weight-bold">SISTEMA DE CADASTROS</h1>
                <h3><span class="badge bg-primary">Versão 2.0</span></h3>
            </div>
        </div>
    </div>
    <div class="container text-center col-md-8 col-sm-8 col-xs-12">
        <div class="card-header">
            <h2 class="font-weight-bold bg-primary text-white">Atualizar Fornecedor</h2>
            <div class="card-header">
                <form class="form-horizontal" action="update.php?id=<?= $_GET['id'] ?>" method="post">    
                    <div class="control-group">
                        <label class="control-label font-weight-bold">Nome</label>
                        <div class="controls">
                            <input size="50" name="nome" class="form-control container col-md-8 col-sm-8 col-xs-12 text-center" type="text" placeholder="Nome do Fornecedor">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label font-weight-bold">CNPJ</label>
                        <div class="controls">
                            <input size="50" name="cnpj" class="form-control container col-md-8 col-sm-8 col-xs-12 text-center" type="text" placeholder="CNPJ">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label font-weight-bold">Endereço</label>
                        <div class="controls">
                            <input name="endereco" class="form-control container col-md-8 col-sm-8 col-xs-12 text-center" size="80" type="text" placeholder="Endereço">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label font-weight-bold">Telefone</label>
                        <div class="controls">
                            <input name="telefone" class="form-control container col-md-8 col-sm-8 col-xs-12 text-center" size="30" type="text" placeholder="Telefone">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label font-weight-bold">Email</label>
                        <div class="controls">
                            <input name="email" class="form-control container col-md-8 col-sm-8 col-xs-12 text-center" size="40" type="text" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                        <a href="../../../fornecedores.php" type="button" class="btn btn-default">Voltar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="../../../assets/js/bootstrap.min.js"></script>
</body>
</html>
