<?php

namespace App\Controllers;

use App\Models\UsuarioDAO;
use Core\Banco;
use Exception;


class AuthController
{
    private $usuarioDAO;

    public function __construct()
    {
        $this->usuarioDAO = new UsuarioDAO();
    }


    public function register() {
        // Incluir arquivo de configuração
        require_once __DIR__ . '/../../config/config.php';

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
                $usuarioDAO = new UsuarioDAO();
                if ($usuarioDAO->findByUsername(trim($_POST["username"]))) {
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
                $usuario = new Usuario();
                $usuario->setUsername($username);
                $usuario->setPassword(password_hash($password, PASSWORD_DEFAULT));

                if ($usuarioDAO->create($usuario)) {
                    // Redirecionar para a página de Index
                    header("location: index.php");
                    exit;
                } else {
                    echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
                }
            }
        }

        // Incluir a view de registro
        require_once __DIR__ . '/../../app/Views/auth/register.php';
    }


    public function login() {
        session_start();

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
                $usuarioDAO = new UsuarioDAO();
                $user = $usuarioDAO->findByUsername($username);

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

        require_once __DIR__ . '/../../app/Views/auth/login.php';
    }

    public function resetPassword($data)
    {
        $errors = [];

        // Verificação do ID do usuário
        if (!isset($_SESSION['id']) || !preg_match('/^[a-f\d]{24}$/i', $_SESSION['id'])) {
            error_log("ID de usuário inválido: " . $_SESSION['id']);
            return ['success' => false, 'message' => 'ID de usuário inválido.'];
        }

        if (empty($data['new_password'])) {
            $errors['new_password_err'] = 'Por favor, insira a nova senha.';
        } elseif (strlen($data['new_password']) < 6) {
            $errors['new_password_err'] = 'A senha deve ter pelo menos 6 caracteres.';
        }

        if (empty($data['confirm_password'])) {
            $errors['confirm_password_err'] = 'Por favor, confirme a senha.';
        } elseif ($data['new_password'] !== $data['confirm_password']) {
            $errors['confirm_password_err'] = 'As senhas não coincidem.';
        }

        if (!empty($errors)) {
            return $errors;
        }

        $userId = $_SESSION['id'];
        $newPassword = $data['new_password'];

        try {
            $success = $this->usuarioDAO->updatePassword($userId, $newPassword);
            if ($success) {
                error_log("Senha atualizada com sucesso para o usuário ID: " . $userId);
                return ['success' => true];
            } else {
                error_log("Falha ao atualizar a senha para o usuário ID: " . $userId);
                return ['success' => false, 'message' => 'Ops Algo deu errado. Por favor, tente novamente mais tarde.'];
            }
        } catch (Exception $e) {
            error_log("Erro ao tentar atualizar a senha: " . $e->getMessage());
            return ['success' => false, 'message' => 'Ops Algo deu errado. Por favor, tente novamente mais tarde.'];
        }
    }
}
?>
