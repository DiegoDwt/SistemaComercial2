<?php
// Incluir arquivo de configuração
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__. '/../../../core/banco.php';    // Subir duas pastas e acessar core

// Inicialize a conexão com o banco de dados
$database = Core\Banco::getDatabase();

// Defina variáveis e inicialize com valores vazios
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Processando dados do formulário quando o formulário é enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validar nome de usuário
    if (empty(trim($_POST["username"]))) {
        $username_err = "Por favor coloque um nome de usuário.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "O nome de usuário pode conter apenas letras, números e sublinhados.";
    } else {
        // Verifique se o nome de usuário já existe
        $collection = $database->users; // Selecionar a coleção de usuários
        $user = $collection->findOne(['username' => trim($_POST["username"])]);

        if ($user) {
            $username_err = "Este nome de usuário já está em uso.";
        } else {
            $username = trim($_POST["username"]);
        }
    }

    // Validar senha
    if (empty(trim($_POST["password"]))) {
        $password_err = "Por favor insira uma senha.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "A senha deve ter pelo menos 6 caracteres.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validar e confirmar a senha
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Por favor, confirme a senha.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "A senha não confere.";
        }
    }

    // Verifique os erros de entrada antes de inserir no banco de dados
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        // Inserir novo usuário no MongoDB
        $newUser = [
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT) // Cria um hash da senha
        ];

        $result = $collection->insertOne($newUser);

        if ($result->getInsertedCount() == 1) {
            // Redirecionar para a página de Index
            header("Location: /Agenda_MongoBD3/index.php");
            exit;
        } else {
            echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../../../assets/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
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
        <h2 class="font-weight-bold bg-primary text-white"> Atualizar dados </h2>
        <div class="card-header">
            <h2 class="font-weight-bold">Cadastro</h2>
            <p>Por favor, preencha este formulário para criar uma conta.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="h5">
                    <label class="font-weight-bold">Nome do usuário</label>
                    <input type="text" name="username" placeholder="Nome" class="form-control container col-md-8 col-sm-8 col-xs-12 text-center <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>    
                <div class="h5">
                    <label class="font-weight-bold">Senha</label>
                    <input type="password" name="password" placeholder="Senha" class="form-control container col-md-8 col-sm-8 col-xs-12 text-center<?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="h5">
                    <label class="font-weight-bold">Confirme a senha</label>
                    <input type="password" name="confirm_password" placeholder="Confirme a Senha" class="form-control container col-md-8 col-sm-8 col-xs-12 text-center<?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="h5">
                    <input type="submit" class="btn btn-primary" value="Criar Conta">
                    <input type="reset" class="btn btn-secondary ml-2" value="Apagar Dados">
                </div>
                <p>Já tem uma conta? <a href="../../../index.php">Entre aqui</a>.</p>
            </form>
        </div>
    </div> 
</div>   
</body>
</html>
