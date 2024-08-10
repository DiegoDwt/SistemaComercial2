<?php
namespace App\Views\Fornecedores;

session_start();

use Core\Banco;
use App\Models\FornecedorDAO;
use MongoDB\BSON\ObjectId;

require_once '../../../core/Banco.php';

// Verifica se o usuário está logado
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../../index.php");
    exit;
}

// Obtém o ID do fornecedor da URL e valida
$idFornecedor = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
if (!$idFornecedor || !isValidObjectId($idFornecedor)) {
    echo "ID de fornecedor inválido.";
    exit;
}

// Função para validar se uma string é um ObjectId válido
function isValidObjectId(string $id): bool {
    return (bool) preg_match('/^[a-f\d]{24}$/i', $id);
}

try {
    // Cria um objeto ObjectId
    $objectId = new ObjectId($idFornecedor);

    // Conexão com o banco de dados e obtenção da coleção
    $client = Banco::conectar();
    $database = Banco::getDatabase();
    $collection = $database->Fornecedores;

    // Carrega o DAO do Fornecedor para buscar os dados
    $fornecedorDAO = new FornecedorDAO($collection);
    $data = $fornecedorDAO->read($objectId);

} catch (\Throwable $th) {
    echo "Erro ao buscar fornecedor: " . $th->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../../assets/css/bootstrap.min.css">
    <title>Dados do Fornecedor</title>
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
        <h2 class="font-weight-bold bg-primary text-white">Dados do Fornecedor</h2>
        <div class="container">
            <div class="form-horizontal">
                <?php if ($data): ?>
                    <div class="control-group container text-center col-md-6 col-sm-6 col-xs-12">
                        <label class="control-label font-weight-bold">Nome</label>
                        <div class="controls form-control">
                            <label class="carousel-inner">
                                <?php echo htmlspecialchars($data->getNome()); ?>
                            </label>
                        </div>
                    </div>

                    <div class="control-group container text-center col-md-6 col-sm-6 col-xs-12">
                        <label class="control-label font-weight-bold">CNPJ</label>
                        <div class="controls form-control disabled">
                            <label class="carousel-inner">
                                <?php echo htmlspecialchars($data->getCnpj()); ?>
                            </label>
                        </div>
                    </div>

                    <div class="control-group container text-center col-md-6 col-sm-6 col-xs-12">
                        <label class="control-label font-weight-bold">Endereço</label>
                        <div class="controls form-control disabled">
                            <label class="carousel-inner">
                                <?php echo htmlspecialchars($data->getEndereco()); ?>
                            </label>
                        </div>
                    </div>

                    <div class="control-group container text-center col-md-6 col-sm-6 col-xs-12">
                        <label class="control-label font-weight-bold">Telefone</label>
                        <div class="controls form-control disabled">
                            <label class="carousel-inner">
                                <?php echo htmlspecialchars($data->getTelefone()); ?>
                            </label>
                        </div>
                    </div>

                    <div class="control-group container text-center col-md-6 col-sm-6 col-xs-12">
                        <label class="control-label font-weight-bold">Email</label>
                        <div class="controls form-control disabled">
                            <label class="carousel-inner">
                                <?php echo htmlspecialchars($data->getEmail()); ?>
                            </label>
                        </div>
                    </div>

                    <div class="control-group container text-center col-md-6 col-sm-6 col-xs-12">
                        <label class="control-label font-weight-bold">Tipo de Fornecedor</label>
                        <div class="controls form-check disabled">
                            <label class="carousel-inner">
                                <?php echo htmlspecialchars($data->getDescricao()); ?>
                            </label>
                        </div>
                    </div>
                    <br/>
                    <div class="text-center">
                        <a href="../../../fornecedores.php"><button type="button" class="btn btn-primary">Voltar</button></a>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger" role="alert">
                        Fornecedor não encontrado.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="../../../assets/js/bootstrap.min.js"></script>
</body>
</html>
