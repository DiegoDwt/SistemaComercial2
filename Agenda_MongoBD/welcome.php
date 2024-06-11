<?php
// Inicialize a sessão
session_start();
 
// Verifique se o usuário está logado, se não, redirecione-o para uma página de login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>
 
 <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <title>Bem vindo</title>
    </head>
    <body>
            <div class="container col-md-8 col-sm-8 col-xs-12 form-group has-feedback" >
                  <div class="jumbotron bg-primary">
                      <div class="row text-white"  >
                          <h1 class="font-weight-bold">SISTEMA DE CADASTROS</h1><h3><span class="badge bg-primary"> Versão 1.0</span></h3>
                      </div>
                  </div>
                <div class="card-header">
                  <h4 class="my-5 text-center">Oi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Selecione o tipo de cadastro desejado.</h1>
                  <br>
                  <p class="text-center">
                    <a href="clientes.php"> <button type="button" class="btn btn-primary btn-lg"><h2>Clientes</h2></button></a>
                    <a href="fornecedores.php" ><button type="button" class="btn btn-secondary btn-lg"><h2>Fornecedores<h2></button></a>
                  </p>
                  <br><br><br><br>
                  <footer>
                    <div class="form-actions text-center">
                        <a href="reset-password.php"><button type="button" class="btn btn-primary">Atualizar Senha</button></a>
                        <a href="logout.php" type="btn" class="btn btn-default">Sair</a>
                    </div>
                  </footer>
             </div>
     </body>
</html>