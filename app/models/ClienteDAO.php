<?php

namespace App\Models;

use MongoDB\BSON\ObjectId;
use MongoDB\Collection;
use Core\Banco;

class ClienteDAO
{
    private Collection $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function updateCliente($id, $nome, $cpf, $endereco, $telefone, $email, $sexo) {
        try {
            // Atualiza os dados do cliente
            $updateResult = $this->collection->updateOne(
                ['_id' => new ObjectId($id)],
                ['$set' => [
                    'nome' => $nome,
                    'cpf' => $cpf,
                    'endereco' => $endereco,
                    'telefone' => $telefone,
                    'email' => $email,
                    'sexo' => $sexo
                ]]
            );

            return $updateResult->getModifiedCount() > 0; // Retorna true se houver modificações
        } catch (\Throwable $th) {
            throw new \Exception('Erro ao atualizar o cliente: ' . $th->getMessage());
        }
    }
    
    public function read(string $id): ?Cliente
    {
        $documento = $this->collection->findOne(['_id' => new ObjectId($id)]);
        if ($documento) {
            return new Cliente(
                $documento['nome'],
                $documento['cpf'],
                $documento['endereco'],
                $documento['telefone'],
                $documento['email'],
                $documento['sexo']
            );
        }
        return null;
    }
    

    public function create(Cliente $cliente): void
    {
        $documento = [
            'nome' => $cliente->getNome(),
            'cpf' => $cliente->getCpf(),
            'endereco' => $cliente->getEndereco(),
            'telefone' => $cliente->getTelefone(),
            'email' => $cliente->getEmail(),
            'sexo' => $cliente->getSexo()
        ];

        $insertResult = $this->collection->insertOne($documento);
        $insertedId = (string) $insertResult->getInsertedId(); // Obtém o ID inserido como uma string
        $cliente->setId($insertedId);
    }


    public function deleteById(ObjectId $id)
    {
        try {
            $result = $this->collection->deleteOne(['_id' => $id]);
            return $result->getDeletedCount() > 0;
        } catch (\Throwable $th) {
            throw new \Exception('Erro ao excluir o cliente: ' . $th->getMessage());
        }
    }
    


}
?>
