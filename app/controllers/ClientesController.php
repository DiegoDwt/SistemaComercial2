<?php

namespace App\Controllers;

use App\Models\Cliente;
use Core\Banco;
use Psr\Log\LoggerInterface;

class ClienteController {
    private $log;

    public function __construct(LoggerInterface $log) {
        $this->log = $log;
    }

    public function create() {
        // Implementação do método create
        $this->log->info('Tentativa de criação de um novo cliente.');
        
        // Supondo que os dados do cliente venham de uma requisição POST
        $nome = $_POST['nome'] ?? 'Nome Desconhecido';
        $cpf = $_POST['cpf'] ?? 'CPF Desconhecido';
        $endereco = $_POST['endereco'] ?? 'Endereço Desconhecido';
        $telefone = $_POST['telefone'] ?? 'Telefone Desconhecido';
        $email = $_POST['email'] ?? 'Email Desconhecido';
        $sexo = $_POST['sexo'] ?? 'Sexo Desconhecido';

        // Validação e criação do cliente
        $cliente = new Cliente($nome, $cpf, $endereco, $telefone, $email, $sexo);

        $client = Banco::conectar();
        $database = Banco::getDatabase();
        $collection = $database->Clientes;

        try {
            $collection->insertOne([
                'nome' => $cliente->getNome(),
                'cpf' => $cliente->getCpf(),
                'endereco' => $cliente->getEndereco(),
                'telefone' => $cliente->getTelefone(),
                'email' => $cliente->getEmail(),
                'sexo' => $cliente->getSexo()
            ]);
            $this->log->info('Cliente criado com sucesso.', ['nome' => $cliente->getNome(), 'cpf' => $cliente->getCpf()]);
        } catch (\Exception $e) {
            $this->log->error('Erro ao criar cliente.', ['exception' => $e->getMessage()]);
        } finally {
            Banco::desconectar();
        }
    }

    public function update($id) {
        // Implementação do método update
        $this->log->info('Tentativa de atualização de um cliente.', ['id' => $id]);
        
        // Supondo que os dados do cliente venham de uma requisição POST
        $nome = $_POST['nome'] ?? 'Nome Desconhecido';
        $cpf = $_POST['cpf'] ?? 'CPF Desconhecido';
        $endereco = $_POST['endereco'] ?? 'Endereço Desconhecido';
        $telefone = $_POST['telefone'] ?? 'Telefone Desconhecido';
        $email = $_POST['email'] ?? 'Email Desconhecido';
        $sexo = $_POST['sexo'] ?? 'Sexo Desconhecido';

        $client = Banco::conectar();
        $database = Banco::getDatabase();
        $collection = $database->Clientes;

        try {
            $collection->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectId($id)],
                ['$set' => [
                    'nome' => $nome,
                    'cpf' => $cpf,
                    'endereco' => $endereco,
                    'telefone' => $telefone,
                    'email' => $email,
                    'sexo' => $sexo
                ]]
            );
            $this->log->info('Cliente atualizado com sucesso.', ['id' => $id, 'nome' => $nome, 'cpf' => $cpf]);
        } catch (\Exception $e) {
            $this->log->error('Erro ao atualizar cliente.', ['id' => $id, 'exception' => $e->getMessage()]);
        } finally {
            Banco::desconectar();
        }
    }

    public function delete($id) {
        // Implementação do método delete
        $this->log->info('Tentativa de exclusão de um cliente.', ['id' => $id]);

        $client = Banco::conectar();
        $database = Banco::getDatabase();
        $collection = $database->Clientes;

        try {
            $collection->deleteOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);
            $this->log->info('Cliente excluído com sucesso.', ['id' => $id]);
        } catch (\Exception $e) {
            $this->log->error('Erro ao excluir cliente.', ['id' => $id, 'exception' => $e->getMessage()]);
        } finally {
            Banco::desconectar();
        }
    }
}
?>
