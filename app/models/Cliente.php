<?php

namespace App\Models;

class Cliente
{
    private ?string $id; // ID pode ser nulo ou string
    private string $nome;
    private string $cpf;    
    private string $endereco;
    private string $telefone;
    private string $email;
    private string $sexo;

    public function __construct(string $nome, string $cpf, string $endereco, string $telefone, string $email, string $sexo, ?string $id = null)
    {
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->endereco = $endereco;
        $this->telefone = $telefone;
        $this->email = $email;
        $this->sexo = $sexo;
        $this->id = $id; 
    }

    // Métodos getters
    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getCpf(): string
    {
        return $this->cpf;
    }

    public function getEndereco(): string
    {
        return $this->endereco;
    }

    public function getTelefone(): string
    {
        return $this->telefone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getSexo(): string
    {
        return $this->sexo;
    }
}
?>
