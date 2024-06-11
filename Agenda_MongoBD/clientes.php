<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Clientes</title>
</head>

<body>
    <div class="container col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
        <div class="jumbotron bg-primary">
            <div class="row text-white">
                <h1 class="font-weight-bold">SISTEMA DE CADASTROS</h1>
                <h3><span class="badge bg-primary"> Versão 1.0</span></h3>
            </div>
        </div>
    </div>
    <div class="card-header container text-center col-md-8 col-sm-8 col-xs-12">
        <h2 class="font-weight-bold bg-primary text-white"> Clientes </h2>
        <div class="text-center">
            <p>
                <a href="create.php" class="btn btn-success">Adicionar</a>
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
                <?php
                include 'banco.php';
                $client = Banco::conectar(); // Usando o método conectar modificado para MongoDB
                $database = Banco::getDatabase();
                $collection = $database->Clientes; // Acessa a coleção 'Clientes'

                // Função para converter documentos do MongoDB em arrays associativos
                function convertDocumentToRow($doc) {
                    return [
                        'id' => (string) $doc['_id'], // Converte ObjectId para string
                        'nome' => $doc['nome'],
                        'cpf' => $doc['cpf'],
                        'endereco' => $doc['endereco'],
                        'telefone' => $doc['telefone'],
                        'email' => $doc['email'],
                        'sexo' => $doc['sexo']
                    ];
                }

                // Buscar documentos na coleção
                $rows = [];
                foreach ($collection->find([], ['sort' => ['_id' => 1], 'limit' => 100]) as $doc) {
                    $rows[] = convertDocumentToRow($doc);
                }

                // Exibir documentos
                foreach ($rows as $row) {
                    echo '<tr>';
                    echo '<th scope="row">'. $row['id']. '</th>';
                    echo '<td>'. $row['nome']. '</td>';
                    echo '<td>'. $row['cpf']. '</td>';
                    echo '<td>'. $row['endereco']. '</td>';
                    echo '<td>'. $row['telefone']. '</td>';
                    echo '<td>'. $row['email']. '</td>';
                    echo '<td>'. $row['sexo']. '</td>';
                    echo '<td width=250>';
                    echo '<a class="btn btn-primary" href="read.php?id='.urlencode($row['id']).'">Info</a>';
                    echo ' ';
                    echo '<a class="btn btn-warning" href="update.php?id='.urlencode($row['id']).'">Atualizar</a>';
                    echo ' ';
                    echo '<a id="deleteBtn'.$row['id'].'" class="btn btn-danger" href="#">Excluir</a>';
                    echo ' ';
                    echo '<form id="deleteForm'.$row['id'].'" action="delete.php" method="post" style="display:none;">';
                    echo '<input type="hidden" name="id" value="'.$row['id'].'">';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }

                Banco::desconectar();
               ?>
            </tbody>
        </table>
    </div>
    <div class="text-center">
        <a href="welcome.php"><button type="button" class="btn btn-primary">Voltar</button></a>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.btn-danger').click(function(e) {
            var btnId = $(this).attr('id');
            var formId = btnId.replace('deleteBtn', 'deleteForm');
            $('#' + formId).submit();
        });
    });
    </script>
</body>

</html>
