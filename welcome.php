<?php
// Inicialize a sessão
session_start();


// Verifique se o usuário está logado, se não, redirecione-o para uma página de login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Bem vindo</title>
</head>

<body>
    <div class="container">
        <div class="jumbotron bg-primary">
            <div class="row text-white">
                <h1 class="font-weight-bold">SISTEMA DE CADASTROS</h1>
                <h3><span class="badge bg-primary"> Versão 2.0</span></h3>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="my-5 text-center">Oi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Selecione o tipo de cadastro desejado.</h4>
                <div class="text-center">
                    <a href="clientes.php" class="btn btn-primary btn-lg 
                    mx-3"><h2>Clientes</h2></a>
                    <a href="fornecedores.php" class="btn btn-secondary btn-lg mx-3"><h2>Fornecedores</h2></a>
                </div>
                <br><br><br><br>
                <footer>
                    <div class="form-actions text-center">
                        <a href="app/views/auth/reset-password.php" class="btn btn-primary">Atualizar Senha</a>
                        <a href="app/views/auth/logout.php" class="btn btn-default">Sair</a>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</body>

</html>
