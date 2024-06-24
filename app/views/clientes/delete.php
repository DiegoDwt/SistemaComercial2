    <?php
    session_start();

    // Verifica se o usuário está logado
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: ../../index.php");
        exit;
    }

    // Verifica o token CSRF
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    // Verifica se o ID do cliente foi enviado
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        die('ID do cliente não fornecido');
    }

    // Inclui o arquivo de configuração do banco de dados e a classe Cliente
    require_once '../../../core/banco.php';
    require_once '../../../app/models/Cliente.php';

    use Core\Banco;

    // Conecta ao banco de dados
    $client = Banco::conectar();
    if (!$client) {
        die("Erro ao conectar ao banco de dados");
    }

    $database = Banco::getDatabase();
    $collection = $database->Clientes;

    // Deleta o cliente
    $id = $_POST['id'];
    $result = $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

    if ($result->getDeletedCount() === 1) {
        echo "Cliente excluído com sucesso!";
        header("location: ../../../clientes.php");
        exit;
    } else {
        echo "Erro ao excluir cliente.";
    }

    // Fecha a conexão com o banco de dados
    Banco::desconectar();
    ?>
