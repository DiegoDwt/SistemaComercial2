<?php
require 'banco.php';

// Verifica se a solicitação é para visualizar o formulário
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Renderiza o formulário
    // Aqui você deve colocar o código HTML do seu formulário
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $sexo = $_POST['sexo'];

    $client = Banco::conectar();

    try {
        $db = $client->selectDatabase('Agenda');
        $collection = $db->selectCollection('Clientes');

        // Encontrar o documento pelo email, assumindo que o email é um campo único
        $documento = $collection->findOne(['email' => $email]);

        if ($documento) {
            // Atualiza os dados do cliente
            $collection->updateOne(
                ['_id' => $documento['_id']],
                [
                    '$set' => [
                        'nome' => $nome,
                        'cpf' => $cpf,
                        'endereco' => $endereco,
                        'telefone' => $telefone,
                        'email' => $email,
                        'sexo' => $sexo
                    ]
                ]
            );

            echo "Dados do cliente atualizados com sucesso!";
        } else {
            echo "Cliente não encontrado.";
        }
    } catch (Exception $e) {
        echo "Erro ao atualizar os dados do cliente: ". $e->getMessage();
    }

    Banco::desconectar();
} else {
    echo "O formulário de atualização não foi enviado.";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Atualizar</title>
</head>
<body>
    <div class="container col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
        <div class="jumbotron bg-primary">
            <div class="row text-white">
                <h1 class="font-weight-bold">SISTEMA DE CADASTROS</h1>
                <h3><span class="badge bg-primary">Versão 1.0</span></h3>
            </div>
        </div>
    </div>
    <div class="container text-center col-md-8 col-sm-8 col-xs-12">
        <div class="card-header">
            <h2 class="font-weight-bold bg-primary text-white">Atualizar dados</h2>
            <div class="card-header">
                <div class="wrapper text-center">
                    <form class="form-horizontal" action="" method="post">
                        <div class="control-group">
                            <label class="control-label font-weight-bold">Nome</label>
                            <div class="controls">
                                <input size="50" name="nome" class="form-control container col-md-8 col-sm-8 col-xs-12 text-center" type="text" placeholder="Nome">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label font-weight-bold">CPF</label>
                            <div class="controls">
                                <input size="50" name="cpf" class="form-control container col-md-8 col-sm-8 col-xs-12 text-center" type="text" placeholder="CPF">
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
                        <div class="control-group">
                            <label class="control-label font-weight-bold">Sexo</label>
                            <div class="controls">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sexo" id="sexo" value="M" checked> Masculino
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sexo" id="sexo" value="F"> Feminino
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                            <a href="clientes.php" type="button" class="btn btn-default">Voltar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>
