<?php
require 'banco.php';

// Processar somente quando houver uma chamada POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeErro = null;
    $cpfErro = null;
    $enderecoErro = null;
    $telefoneErro = null;
    $emailErro = null;
    $sexoErro = null;
    $validacao = true;

    if (!empty($_POST)) {
        if (!empty($_POST['nome'])) {
            $nome = $_POST['nome'];
        } else {
            $nomeErro = 'Por favor digite o seu nome!';
            $validacao = false;
        }

        if (!empty($_POST['cpf'])) {
            $cpf = $_POST['cpf'];
        } else {
            $cpfErro = 'Por favor digite o seu CPF!';
            $validacao = false;
        }

        if (!empty($_POST['endereco'])) {
            $endereco = $_POST['endereco'];
        } else {
            $enderecoErro = 'Por favor digite o seu endereço!';
            $validacao = false;
        }

        if (!empty($_POST['telefone'])) {
            $telefone = $_POST['telefone'];
        } else {
            $telefoneErro = 'Por favor digite o número do telefone!';
            $validacao = false;
        }

        if (!empty($_POST['email'])) {
            $email = $_POST['email'];
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $emailErro = 'Por favor digite um endereço de email válido!';
                $validacao = false;
            }
        } else {
            $emailErro = 'Por favor digite um endereço de email!';
            $validacao = false;
        }

        if (!empty($_POST['sexo'])) {
            $sexo = $_POST['sexo'];
        } else {
            $sexoErro = 'Por favor seleccione um campo!';
            $validacao = false;
        }

        // Inserindo no Banco:
        if ($validacao) {
            $client = Banco::conectar(); // Usando o método conectar modificado para MongoDB
            $collection = $client->Agenda->Clientes; // Acessando a coleção diretamente

            $documento = [
                'nome' => $nome,
                'cpf' => $cpf,
                'endereco' => $endereco,
                'telefone' => $telefone,
                'email' => $email,
                'sexo' => $sexo
            ];

            try {
                $collection->insertOne($documento);
                Banco::desconectar();
                header("Location: clientes.php");
                exit(); // Encerra a execução após redirecionamento
            } catch (Exception $e) {
                echo "Falha ao criar o usuário.";
            }
        }
    }
}
?>


<!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <title>Adicionar contato</title>
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
                    <h2 class="font-weight-bold bg-primary text-white"> Cadastro de Cliente</h2>
           <div class="wrapper text-center">
                <form class="form-horizontal" action="create.php" method="post">
                    <div class="control-group  <?php echo !empty($nomeErro) ? 'error ' : ''; ?>">
                        <label class="control-label font-weight-bold">Nome</label>
                        <div class="controls">
                            <input size="50" class="form-control container col-md-6 col-sm-6 col-xs-12 text-center" name="nome" type="text" placeholder="Nome"
                                   value="<?php echo !empty($nome) ? $nome : ''; ?>">
                            <?php if (!empty($nomeErro)): ?>
                                <span class="text-danger"><?php echo $nomeErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group  <?php echo !empty($cpfErro) ? 'error ' : ''; ?>">
                        <label class="control-label font-weight-bold">CPF</label>
                        <div class="controls">
                            <input size="50" class="form-control container col-md-6 col-sm-6 col-xs-12 text-center" name="cpf" type="text" placeholder="CPF"
                                   value="<?php echo !empty($cpf) ? $cpf : ''; ?>">
                            <?php if (!empty($cpfErro)): ?>
                                <span class="text-danger"><?php echo $cpfErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($enderecoErro) ? 'error ' : ''; ?>">
                        <label class="control-label font-weight-bold">Endereço</label>
                        <div class="controls">
                            <input size="80" class="form-control container col-md-6 col-sm-6 col-xs-12 text-center" name="endereco" type="text" placeholder="Endereço"
                                   value="<?php echo !empty($endereco) ? $endereco : ''; ?>">
                            <?php if (!empty($emailErro)): ?>
                                <span class="text-danger"><?php echo $enderecoErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($telefoneErro) ? 'error ' : ''; ?>">
                        <label class="control-label font-weight-bold">Telefone</label>
                        <div class="controls">
                            <input size="35" class="form-control container col-md-6 col-sm-6 col-xs-12 text-center" name="telefone" type="text" placeholder="Telefone"
                                   value="<?php echo !empty($telefone) ? $telefone : ''; ?>">
                            <?php if (!empty($telefoneErro)): ?>
                                <span class="text-danger"><?php echo $telefoneErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php !empty($emailErro) ? '$emailErro ' : ''; ?>">
                        <label class="control-label font-weight-bold">Email</label>
                        <div class="controls">
                            <input size="40" class="form-control container col-md-6 col-sm-6 col-xs-12 text-center" name="email" type="text" placeholder="Email"
                                   value="<?php echo !empty($email) ? $email : ''; ?>">
                            <?php if (!empty($emailErro)): ?>
                                <span class="text-danger"><?php echo $emailErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php !empty($sexoErro) ? 'echo($sexoErro)' : ''; ?>">
                        <div class="controls">
                            <label class="control-label font-weight-bold">Sexo</label>
                            <div class="form-check">
                                <p class="form-check-label">
                                    <input class="form-check-input" type="radio" name="sexo" id="sexo"
                                           value="M" <?php isset($_POST["sexo"]) && $_POST["sexo"] == "M" ? "checked" : null; ?>/>
                                    Masculino</p>
                            </div>
                            <div class="form-check">
                                <p class="form-check-label">
                                    <input class="form-check-input" id="sexo" name="sexo" type="radio"
                                           value="F" <?php isset($_POST["sexo"]) && $_POST["sexo"] == "F" ? "checked" : null; ?>/>
                                    Feminino</p>
                            </div>
                            <?php if (!empty($sexoErro)): ?>
                                <span class="help-inline text-danger"><?php echo $sexoErro; ?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                    <div class="form-actions">
                        <br/>
                        <button type="submit" class="btn btn-success">Adicionar</button>
                        <a href="clientes.php" type="btn" class="btn btn-default">Voltar</a>
                    </div>
                </form>
            </div>
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>

