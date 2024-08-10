<?php

namespace App\Controllers;

session_start();

use App\Controllers\FornecedorController;
use Core\Banco;

require __DIR__ . '/../../../vendor/autoload.php';
$log = require __DIR__ . '/../../../config/log.php';
require_once __DIR__ . '/../../../app/controllers/FornecedorController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fornecedorController = new FornecedorController($log);
    $fornecedorController->create();
    
    // Redireciona para a página de fornecedores após a criação
    header("Location: ../../../fornecedores.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../assets/css/bootstrap.min.css">
    <title>Adicionar Fornecedor</title>
</head>
<body>
    <div class="container col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
        <div class="jumbotron bg-primary">
            <div class="row text-white">
                <h1 class="font-weight-bold">SISTEMA DE CADASTROS</h1>
                <h3><span class="badge bg-primary"> Versão 2.0</span></h3>
            </div>
        </div>
    </div>
    
    <div class="container text-center col-md-8 col-sm-8 col-xs-12">
        <div class="card-header">
            <h2 class="font-weight-bold bg-primary text-white"> Cadastro de Fornecedor</h2>
            <div class="wrapper text-center">
                <form class="form-horizontal" action="create.php" method="post">
                    <div class="control-group <?php echo !empty($nomeErro) ? 'error ' : ''; ?>">
                        <label class="control-label font-weight-bold">Nome</label>
                        <div class="controls">
                            <input size="50" class="form-control container col-md-6 col-sm-6 col-xs-12 text-center" name="nome" type="text" placeholder="Nome"
                                   value="<?php echo !empty($nome) ? htmlspecialchars($nome) : ''; ?>">
                            <?php if (!empty($nomeErro)): ?>
                                <span class="text-danger"><?php echo htmlspecialchars($nomeErro); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($cnpjErro) ? 'error ' : ''; ?>">
                        <label class="control-label font-weight-bold">CNPJ</label>
                        <div class="controls">
                            <input size="50" class="form-control container col-md-6 col-sm-6 col-xs-12 text-center" name="cnpj" type="text" placeholder="CNPJ"
                                   value="<?php echo !empty($cnpj) ? htmlspecialchars($cnpj) : ''; ?>">
                            <?php if (!empty($cnpjErro)): ?>
                                <span class="text-danger"><?php echo htmlspecialchars($cnpjErro); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($descricaoErro) ? 'error ' : ''; ?>">
                        <label class="control-label font-weight-bold">Descrição</label>
                        <div class="controls">
                            <input size="80" class="form-control container col-md-6 col-sm-6 col-xs-12 text-center" name="descricao" type="text" placeholder="Descrição"
                                   value="<?php echo !empty($descricao) ? htmlspecialchars($descricao) : ''; ?>">
                            <?php if (!empty($descricaoErro)): ?>
                                <span class="text-danger"><?php echo htmlspecialchars($descricaoErro); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($enderecoErro) ? 'error ' : ''; ?>">
                        <label class="control-label font-weight-bold">Endereço</label>
                        <div class="controls">
                            <input size="80" class="form-control container col-md-6 col-sm-6 col-xs-12 text-center" name="endereco" type="text" placeholder="Endereço"
                                   value="<?php echo !empty($endereco) ? htmlspecialchars($endereco) : ''; ?>">
                            <?php if (!empty($enderecoErro)): ?>
                                <span class="text-danger"><?php echo htmlspecialchars($enderecoErro); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($telefoneErro) ? 'error ' : ''; ?>">
                        <label class="control-label font-weight-bold">Telefone</label>
                        <div class="controls">
                            <input size="35" class="form-control container col-md-6 col-sm-6 col-xs-12 text-center" name="telefone" type="text" placeholder="Telefone"
                                   value="<?php echo !empty($telefone) ? htmlspecialchars($telefone) : ''; ?>">
                            <?php if (!empty($telefoneErro)): ?>
                                <span class="text-danger"><?php echo htmlspecialchars($telefoneErro); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($emailErro) ? 'error ' : ''; ?>">
                        <label class="control-label font-weight-bold">Email</label>
                        <div class="controls">
                            <input size="40" class="form-control container col-md-6 col-sm-6 col-xs-12 text-center" name="email" type="text" placeholder="Email"
                                   value="<?php echo !empty($email) ? htmlspecialchars($email) : ''; ?>">
                            <?php if (!empty($emailErro)): ?>
                                <span class="text-danger"><?php echo htmlspecialchars($emailErro); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-actions">
                        <br/>
                        <button type="submit" class="btn btn-success">Adicionar</button>
                        <a href="../../../fornecedores.php" class="btn btn-default">Voltar</a>
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
