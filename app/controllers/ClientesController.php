<?php
namespace App\Controllers;

use App\Views\Cliente;
use App\Models\ClienteDAO;
use Core\Banco; 

class ClientesController {

    public function update() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = $_POST['nome'];
            $cpf = $_POST['cpf'];
            $endereco = $_POST['endereco'];
            $telefone = $_POST['telefone'];
            $email = $_POST['email'];
            $sexo = $_POST['sexo'];
    
            $client = Banco::conectar();
            try {
                $db = $client->selectDatabase('Agenda');
                $collection = $db->selectCollection('Clientes');
    
                $documento = $collection->findOne(['id' => $id]);
    
                if ($documento) {
                    $collection->updateOne(
                        ['_id' => $documento['_id']],
                        ['$set' => [
                            'nome' => $nome,
                            'cpf' => $cpf,
                            'endereco' => $endereco,
                            'telefone' => $telefone,
                            'email' => $email,
                            'sexo' => $sexo
                        ]]
                    );
    
                    // Armazena uma mensagem de sucesso na sessão
                    $_SESSION['message'] = "Dados do cliente atualizados com sucesso";
    
                    // Redireciona para clientes.php
                    header("Location:../../../clientes.php");
                    exit;
                } else {
                    // Armazena uma mensagem de erro na sessão
                    $_SESSION['message'] = "Cliente não encontrado.";
                    header("Location:../../../clientes.php");
                    exit;
                }
            } catch (Exception $e) {
                // Armazena uma mensagem de erro na sessão
                $_SESSION['message'] = "Erro ao atualizar os dados do cliente: ".$e->getMessage();
                header("Location:../../../clientes.php");
                exit;
            }
    
            Banco::desconectar();
        }
    }
    
    public function delete() {
        // Verifica se o ID do cliente foi passado via GET ou POST
        $id = isset($_GET['id'])? $_GET['id'] : $_POST['id'];
    
        $client = Banco::conectar();
        try {
            $db = $client->selectDatabase('Agenda');
            $collection = $db->selectCollection('Clientes');
    
            $resultado = $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
    
            if ($resultado->getDeletedCount() > 0) {
                echo "Cliente excluído com sucesso!";
                header("Location:../../../clientes.php"); // Redireciona para clientes.php
                exit;
            } else {
                echo "Cliente não encontrado.";
            }
        } catch (Exception $e) {
            echo "Erro ao excluir o cliente: ". $e->getMessage();
        }
    
        Banco::desconectar();
    }
    
    
    
    public function create() {
        include_once '../../views/clientes/create.php';
    }

    public function store() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = $_POST['nome'] ?? null;
            $cpf = $_POST['cpf'] ?? null;
            $endereco = $_POST['endereco'] ?? null;
            $telefone = $_POST['telefone'] ?? null;
            $email = $_POST['email'] ?? null;
            $sexo = $_POST['sexo'] ?? null;

            $cliente = new Cliente(null, $nome, $cpf, $endereco, $telefone, $email, $sexo);
            $clienteDAO = new ClienteDAO(Banco::conectar());

            try {
                $clienteDAO->create($cliente);
                Banco::desconectar();
                header("Location: clientes.php");
                exit();
            } catch (Exception $e) {
                echo "Falha ao criar o cliente.";
            }
        }
    }

    public function read($id) {
        $clienteDAO = new ClienteDAO(Banco::getDatabase()->clientes); // Ajuste conforme a estrutura do seu banco
        $cliente = $clienteDAO->read($id);
    
        if ($cliente) {
            // Passa os dados do cliente para a view
            $data = [
                'nome' => $cliente->getNome(),
                'cpf' => $cliente->getCpf(),
                'endereco' => $cliente->getEndereco(),
                'telefone' => $cliente->getTelefone(),
                'email' => $cliente->getEmail(),
                'sexo' => $cliente->getSexo()
            ];
            // Inclui a view passando os dados
            include_once __DIR__ . '/../views/clientes/read.php';
        } else {
            // Trate o erro ou retorne uma mensagem de cliente não encontrado
            echo 'Cliente não encontrado.';
        }
    }   
    
}
?>
