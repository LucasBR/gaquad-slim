<?php
declare(strict_types=1);

namespace App\Domain\User;

use JsonSerializable;

class User implements JsonSerializable
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var string
     */
    private $cpf;
    
    /**
     * @var string
     */
    private $senha;
    
    /**
     * @var bool
     */
    private $admin;

    /**
     * @var Agenda[]
     */
    private $agendas;

    /**
     * @param int|null  $id
     * @param string    $email
     * @param string    $nome
     * @param string    $cpf
     * @param bool      $admin
     */
    public function __construct(?int $id, string $email, string $nome, string $cpf, string $senha, bool $admin, array $agendas = [])
    {
        $this->id = $id;
        $this->email = strtolower($email);
        $this->nome = ucfirst($nome);
        $this->cpf = ucfirst($cpf);
        $this->senha = $senha; //crypt
        $this->admin = $admin;

        $this->agendas = $agendas;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @return string
     */
    public function getCpf(): string
    {
        return $this->cpf;
    }

    /**
     * @return string
     */
    public function getSenha(): string
    {
        return $this->senha;
    }
    
    /**
     * @return bool
     */
    public function getAdmin(): bool
    {
        return $this->admin;
    }

    /**
     * @var Agenda[] $agendas
     */
    public function setAgendas(array $agendas)
    {
        $this->agendas = $agendas;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'nome' => $this->nome,
            'cpf' => $this->cpf,
            'admin' => $this->admin,
            'agendas' => $this->agendas,
        ];
    }
}
