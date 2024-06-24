<?php
session_start();

include_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/core/banco.php';

$username = $password = "";
$username_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $username_err = "Por favor, insira o nome de usuário.";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Por favor, insira sua senha.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($username_err) && empty($password_err)) {
        $database = Core\Banco::getDatabase();
        $collection = $database->users;
        $user = $collection->findOne(['username' => $username]);

        if ($user) {
            $hashed_password = $user['password'];
            if (password_verify($password, $hashed_password)) {
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $user['_id'];
                $_SESSION["username"] = $user['username'];
                header("location: welcome.php");
                exit;
            } else {
                $login_err = "Nome de usuário ou senha inválidos.";
            }
        } else {
            $login_err = "Nome de usuário ou senha inválidos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Página Inicial</title>
</head>
<body>
    <div class="container col-md-8 col-sm-8 col-xs-12">
        <div class="jumbotron bg-primary">
            <div class="row text-white">
                <h1 class="font-weight-bold">SISTEMA DE CADASTROS</h1>
                <h3><span class="badge bg-primary"> Versão 1.0</span></h3>
            </div>
        </div>
    </div>
    <div class="container text-center col-md-8 col-sm-8 col-xs-12">
        <div class="card-header">
            <h2 class="font-weight-bold bg-primary text-white"> Login </h2>
            <h6>Por favor, preencha os campos para fazer o login.</h6>
            <?php if (!empty($login_err)) : ?>
                <div class="alert alert-danger"><?php echo $login_err; ?></div>
            <?php endif; ?>
            <br>
            <div class="card-header">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="container-fluid">
                        <label class="font-weight-bold">Nome do usuário</label>
                        <input type="text" name="username" placeholder="Nome" class="form-control container col-md-6 col-sm-6 col-xs-12 text-center <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                        <span class="invalid-feedback"><?php echo $username_err; ?></span>
                    </div>    
                    <div class="form-group">
                        <label class="font-weight-bold">Senha</label>
                        <input type="password" name="password" placeholder="Senha" class="form-control container col-md-6 col-sm-6 col-xs-12 text-center <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Entrar">
                    </div>
                    <p>Não tem uma conta? <a href="app/views/auth/register.php">Inscreva-se agora</a>.</p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
