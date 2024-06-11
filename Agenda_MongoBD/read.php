<?php
require 'banco.php';
$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if (null == $id) {
    header("Location: welcome.php");
} else {
    $client = Banco::conectar(); // Usando o método conectar modificado para MongoDB

    try {
        // Selecionando o banco de dados 'Agenda'
        $db = $client->selectDatabase('Agenda');

        // Selecionando a coleção 'Clientes' dentro do banco de dados 'Agenda'
        $collection = $db->selectCollection('Clientes');

        $document = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
        $data = [
            'nome' => $document['_id'],
            'cpf' => $document['cpf'],
            'endereco' => $document['endereco'],
            'telefone' => $document['telefone'],
            'email' => $document['email'],
            'sexo' => $document['sexo']
        ];
    } catch (Exception $e) {
        die("ERROR: Falha ao buscar os dados do cliente. " . $e->getMessage());
    }
    Banco::desconectar();
}
?>

    <!DOCTYPE html>
        <html lang="pt-br">

        <head>
            <meta charset="utf-8">
            <link rel="stylesheet" href="assets/css/bootstrap.min.css">
            <title>Dados do Cliente</title>
        </head>
        <body>
                <div class="container col-md-8 col-sm-8 col-xs-12 form-group has-feedback" >
                <div class="jumbotron bg-primary">
                    <div class="row text-white"  >
                        <h1 class="font-weight-bold">SISTEMA DE CADASTROS</h1><h3><span class="badge bg-primary"> Versão 1.0</span></h3>
                    </div>
                </div>
                </div>
                <div class="container text-center col-md-8 col-sm-8 col-xs-12">
                    <div class="card-header">
                        <h2 class="font-weight-bold bg-primary text-white">Dados do Cliente </h2>
                        <div class="container">
                            <div class="form-horizontal">
                                <div class="control-group container text-center col-md-6 col-sm-6 col-xs-12">
                                    <label class="control-label font-weight-bold">Nome</label>
                                    <div class="controls form-control">
                                        <label class="carousel-inner">
                                            <?php echo $data['nome']; ?>
                                        </label>
                                    </div>
                                </div>

                                <div class="control-group container text-center col-md-6 col-sm-6 col-xs-12">
                                    <label class="control-label font-weight-bold">CPF</label>
                                    <div class="controls form-control disabled">
                                        <label class="carousel-inner">
                                            <?php echo $data['cpf']; ?>
                                        </label>
                                    </div>
                                </div>

                                <div class="control-group container text-center col-md-6 col-sm-6 col-xs-12">
                                    <label class="control-label font-weight-bold">Endereço</label>
                                    <div class="controls form-control disabled">
                                        <label class="carousel-inner">
                                            <?php echo $data['endereco']; ?>
                                        </label>
                                    </div>
                                </div>

                                <div class="control-group container text-center col-md-6 col-sm-6 col-xs-12">
                                    <label class="control-label font-weight-bold">Telefone</label>
                                    <div class="controls form-control disabled">
                                        <label class="carousel-inner">
                                            <?php echo $data['telefone']; ?>
                                        </label>
                                    </div>
                                </div>

                                <div class="control-group container text-center col-md-6 col-sm-6 col-xs-12">
                                    <label class="control-label font-weight-bold">Email</label>
                                    <div class="controls form-control disabled">
                                        <label class="carousel-inner ">
                                            <?php echo $data['email']; ?>
                                        </label>
                                    </div>
                                </div>

                                <div class="control-group container text-center col-md-6 col-sm-6 col-xs-12">
                                    <label class="control-label font-weight-bold">Sexo</label>
                                    <div class="controls form-check disabled">
                                        <label class="carousel-inner container text-center col-md-6 col-sm-6 col-xs-12">
                                            <?php echo $data['sexo']; ?>
                                        </label>
                                    </div>
                                </div>
                                <br/>
                                <div class="text-center">
                                <a href="clientes.php"><button type="buttom" class="btn btn-primary">Voltar</button></a>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
            crossorigin="anonymous"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    </body>

    </html>
