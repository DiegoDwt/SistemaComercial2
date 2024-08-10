<?php

namespace App\Models;

class Fornecedor
{
    private ?string $id; // ID pode ser nulo ou string
    private string $nome;
    private string $cnpj;
    private string $descricao;    
    private string $endereco;
    private string $telefone;
    private string $email;

    public function __construct(string $nome, string $cnpj, string $descricao, string $endereco, string $telefone, string $email, ?string $id = null)
    {
        $this->nome = $nome;
        $this->cnpj = $cnpj;
        $this->descricao = $descricao;
        $this->endereco = $endereco;
        $this->telefone = $telefone;
        $this->email = $email;
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

    public function getCnpj(): string
    {
        return $this->cnpj;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
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
}
?>
