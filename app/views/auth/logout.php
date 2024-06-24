<?php


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


// Remova todas as variáveis de sessão
$_SESSION = array();

// Destrua a sessão.
session_destroy();

// Redirecionar para a página de login
header("Location: ../../../index.php");

exit;
?>
