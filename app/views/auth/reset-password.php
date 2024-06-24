<?php
// Inicialize a sessão
session_start();

// Verifique se o usuário está logado, caso contrário, redirecione para a página de login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Incluir arquivo de configuração
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../app/Controllers/AuthController.php';

use App\Controllers\AuthController;

$authController = new AuthController();

$new_password_err = $confirm_password_err = $message = '';

// Processando dados do formulário quando o formulário é enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $result = $authController->resetPassword($_POST);
    $new_password_err = $result['new_password_err'] ?? '';
    $confirm_password_err = $result['confirm_password_err'] ?? '';
    if (isset($result['success']) && $result['success']) {
        // Redirecionar ou exibir mensagem de sucesso
        header("location: ../../../welcome.php");
        exit;
    } elseif (isset($result['message'])) {
        $message = $result['message'];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../../assets/css/bootstrap.min.css">
    <title>Atualizar senha</title>
</head>
<body>
    <div class="container col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
        <div class="jumbotron bg-primary">
            <div class="row text-white">
                <h1 class="font-weight-bold">SISTEMA DE CADASTROS</h1>
                <h3><span class="badge bg-primary">Versão 1.0</span></h3>
            </div>
        </div>
        <div class="container text-center col-md-8 col-sm-8 col-xs-12">
            <div class="card-header">
                <h2 class="font-weight-bold bg-primary text-white">Atualizar senha</h2>
                <h6 class="font-weight-bold">Por favor, preencha este formulário para redefinir sua senha.</h6>
                <?php if (!empty($message)): ?>
                    <div class="alert alert-danger"><?php echo $message; ?></div>
                <?php endif; ?>
                <div class="card-header">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label class="font-weight-bold">Nova senha</label>
                            <input type="password" name="new_password" class="form-control container col-md-6 col-sm-6 col-xs-12 <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $_POST['new_password'] ?? ''; ?>">
                            <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Confirme a senha</label>
                            <input type="password" name="confirm_password" class="form-control container col-md-6 col-sm-6 col-xs-12 <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Redefinir">
                            <a class="btn btn-link ml-2" href="../../../welcome.php">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
