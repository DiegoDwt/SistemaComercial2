<?php

namespace App\Controllers;

use App\Models\Fornecedor;
use Core\Banco;
use Psr\Log\LoggerInterface;

class FornecedorController
{
    private LoggerInterface $log;

    public function __construct(LoggerInterface $log)
    {
        $this->log = $log;
    }

    public function create()
    {
        // Implementação do método create
        $this->log->info('Tentativa de criação de um novo fornecedor.');

        // Supondo que os dados do fornecedor venham de uma requisição POST
        $nome = $_POST['nome'] ?? 'Nome Desconhecido';
        $cnpj = $_POST['cnpj'] ?? 'CNPJ Desconhecido';
        $descricao = $_POST['descricao'] ?? 'Descrição Desconhecida';
        $endereco = $_POST['endereco'] ?? 'Endereço Desconhecido';
        $telefone = $_POST['telefone'] ?? 'Telefone Desconhecido';
        $email = $_POST['email'] ?? 'Email Desconhecido';

        // Validação e criação do fornecedor
        $fornecedor = new Fornecedor($nome, $cnpj, $descricao, $endereco, $telefone, $email);

        $client = Banco::conectar();
        $database = Banco::getDatabase();
        $collection = $database->Fornecedores;

        try {
            $collection->insertOne([
                'nome' => $fornecedor->getNome(),
                'cnpj' => $fornecedor->getCnpj(),
                'descricao' => $fornecedor->getDescricao(),
                'endereco' => $fornecedor->getEndereco(),
                'telefone' => $fornecedor->getTelefone(),
                'email' => $fornecedor->getEmail()
            ]);
            $this->log->info('Fornecedor criado com sucesso.', ['nome' => $fornecedor->getNome(), 'cnpj' => $fornecedor->getCnpj()]);
        } catch (\Exception $e) {
            $this->log->error('Erro ao criar fornecedor.', ['exception' => $e->getMessage()]);
        } finally {
            Banco::desconectar();
        }
    }

    public function update($id)
    {
        // Implementação do método update
        $this->log->info('Tentativa de atualização de um fornecedor.', ['id' => $id]);

        // Supondo que os dados do fornecedor venham de uma requisição POST
        $nome = $_POST['nome'] ?? 'Nome Desconhecido';
        $cnpj = $_POST['cnpj'] ?? 'CNPJ Desconhecido';
        $descricao = $_POST['descricao'] ?? 'Descrição Desconhecida';
        $endereco = $_POST['endereco'] ?? 'Endereço Desconhecido';
        $telefone = $_POST['telefone'] ?? 'Telefone Desconhecido';
        $email = $_POST['email'] ?? 'Email Desconhecido';

        $client = Banco::conectar();
        $database = Banco::getDatabase();
        $collection = $database->Fornecedores;

        try {
            $collection->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectId($id)],
                ['$set' => [
                    'nome' => $nome,
                    'cnpj' => $cnpj,
                    'descricao' => $descricao,
                    'endereco' => $endereco,
                    'telefone' => $telefone,
                    'email' => $email
                ]]
            );
            $this->log->info('Fornecedor atualizado com sucesso.', ['id' => $id, 'nome' => $nome, 'cnpj' => $cnpj]);
        } catch (\Exception $e) {
            $this->log->error('Erro ao atualizar fornecedor.', ['id' => $id, 'exception' => $e->getMessage()]);
        } finally {
            Banco::desconectar();
        }
    }

    public function delete($id)
    {
        // Implementação do método delete
        $this->log->info('Tentativa de exclusão de um fornecedor.', ['id' => $id]);

        $client = Banco::conectar();
        $database = Banco::getDatabase();
        $collection = $database->Fornecedores;

        try {
            $collection->deleteOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);
            $this->log->info('Fornecedor excluído com sucesso.', ['id' => $id]);
        } catch (\Exception $e) {
            $this->log->error('Erro ao excluir fornecedor.', ['id' => $id, 'exception' => $e->getMessage()]);
        } finally {
            Banco::desconectar();
        }
    }
}
?>
