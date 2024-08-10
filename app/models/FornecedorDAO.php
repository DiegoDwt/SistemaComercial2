<?php

namespace App\Models;

use MongoDB\BSON\ObjectId;
use MongoDB\Collection;

class FornecedorDAO
{
    private Collection $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function updateFornecedor($id, $nome, $cnpj, $descricao, $endereco, $telefone, $email) {
        try {
            // Atualiza os dados do fornecedor
            $updateResult = $this->collection->updateOne(
                ['_id' => new ObjectId($id)],
                ['$set' => [
                    'nome' => $nome,
                    'cnpj' => $cnpj,
                    'descricao' => $descricao,
                    'endereco' => $endereco,
                    'telefone' => $telefone,
                    'email' => $email
                ]]
            );

            return $updateResult->getModifiedCount() > 0; // Retorna true se houver modificações
        } catch (\Throwable $th) {
            throw new \Exception('Erro ao atualizar o fornecedor: ' . $th->getMessage());
        }
    }
    
    public function read(string $id): ?Fornecedor
    {
        $documento = $this->collection->findOne(['_id' => new ObjectId($id)]);
        if ($documento) {
            return new Fornecedor(
                $documento['nome'],
                $documento['cnpj'],
                $documento['descricao'],
                $documento['endereco'],
                $documento['telefone'],
                $documento['email']
            );
        }
        return null;
    }

    public function create(Fornecedor $fornecedor): void
    {
        $documento = [
            'nome' => $fornecedor->getNome(),
            'cnpj' => $fornecedor->getCnpj(),
            'descricao' => $fornecedor->getDescricao(),
            'endereco' => $fornecedor->getEndereco(),
            'telefone' => $fornecedor->getTelefone(),
            'email' => $fornecedor->getEmail()
        ];

        $insertResult = $this->collection->insertOne($documento);
        $insertedId = (string) $insertResult->getInsertedId(); // Obtém o ID inserido como uma string
        $fornecedor->setId($insertedId);
    }

    public function deleteById(ObjectId $id)
    {
        try {
            $result = $this->collection->deleteOne(['_id' => $id]);
            return $result->getDeletedCount() > 0;
        } catch (\Throwable $th) {
            throw new \Exception('Erro ao excluir o fornecedor: ' . $th->getMessage());
        }
    }
}
?>
