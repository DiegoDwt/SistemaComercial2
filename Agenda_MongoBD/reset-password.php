<?php
// Inicialize a sessão
session_start();

// Verifique se o usuário está logado, caso contrário, redirecione para a página de login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"]!== true){
    header("location: index.php");
    exit;
}

// Incluir arquivo de configuração
require_once "config.php";

// Defina variáveis e inicialize com valores vazios
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

// Processando dados do formulário quando o formulário é enviado
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validação da nova senha
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Por favor insira a nova senha.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "A senha deve ter pelo menos 6 caracteres.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validação e confirmação da senha
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Por favor, confirme a senha.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password!= $confirm_password)){
            $confirm_password_err = "A senha não confere.";
        }
    }
        
    // Verifica os erros de entrada antes de atualizar o banco de dados
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Preparação da consulta de atualização
        $collection = $database->users; // Supondo que você tenha uma coleção chamada 'users'
        $filter = ['_id' => new MongoDB\BSON\ObjectId($_SESSION["id"])]; // Assumindo que 'id' seja armazenado como ObjectId
        $update = ['$set' => ['password' => password_hash($new_password, PASSWORD_DEFAULT)]];

        try {
            $result = $collection->updateOne($filter, $update);
            if($result->getModifiedCount() > 0){
                // Senha atualizada com sucesso. Rdirecione para a página de Welcome
                header("location: welcome.php");
            } else{
                echo "Ops Algo deu errado. Por favor, tente novamente mais tarde.";
            }
        } catch (Exception $e) {
            echo "Ops Algo deu errado. Por favor, tente novamente mais tarde.";
        }
    }
}
?>
 
 <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <title>Atualizar senha</title>
    </head>
    <body>
            <div class="container col-md-8 col-sm-8 col-xs-12 form-group has-feedback" >
              <div class="jumbotron bg-primary">
                  <div class="row text-white"  >
                      <h1 class="font-weight-bold">SISTEMA DE CADASTROS</h1><h3><span class="badge bg-primary"> Versão 1.0</span></h3>
                  </div>
              </div>
            <div>
            <div class="container text-center col-md-8 col-sm-8 col-xs-12">
                <div class="card-header">
                    <h2 class="font-weight-bold bg-primary text-white"> Atualizar senha </h2>
                    <h6 class="font-weight-bold">Por favor, preencha este formulário para redefinir sua senha.</h6>
                    <div class="card-header">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
                            <div class="form-group">
                                <label class="font-weight-bold">Nova senha</label>
                                <input type="password" name="new_password" class="form-control container col-md-6 col-sm-6 col-xs-12 <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                                <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Confirme a senha</label>
                                <input type="password" name="confirm_password" class="form-control container col-md-6 col-sm-6 col-xs-12 <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Redefinir">
                                <a class="btn btn-link ml-2" href="welcome.php">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>    
</body>
</html>