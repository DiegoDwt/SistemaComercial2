<?php

// app/models/UsuarioDAO.php
namespace App\Models;

use MongoDB\BSON\ObjectId;
use MongoDB\Client;
use Core\Banco;

class UsuarioDAO
{
    private $collection;

    public function __construct()
    {
        $client = new Client("mongodb://localhost:27017");
        $database = $client->selectDatabase('Agenda');
        $this->collection = $database->users;
    }

    public function findByUsername($username) {
        return $this->collection->findOne(['username' => $username]);
    }

    public function create($usuario) {
        $newUser = [
            'username' => $usuario->getUsername(),
            'password' => $usuario->getPassword()
        ];

        $result = $this->collection->insertOne($newUser);
        return $result->getInsertedCount() == 1;
    }

    public function updatePassword($userId, $newPassword)
    {
        $filter = ['_id' => new ObjectId($userId)];
        $update = ['$set' => ['password' => password_hash($newPassword, PASSWORD_DEFAULT)]];
    
        try {
            $result = $this->collection->updateOne($filter, $update);
            return $result->getModifiedCount() > 0;
        } catch (\MongoDB\Driver\Exception\Exception $e) {
            error_log("Erro ao atualizar senha: ". $e->getMessage());
            return false;
        }
    }
    
    
}

?>
