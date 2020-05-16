<?php
declare(strict_types=1);

namespace App\Domain\Quadra;

use JsonSerializable;

class Quadra implements JsonSerializable
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var string
     */
    private $preco;

    /**
     * @var Agenda[]
     */
    private $agendas;

    /**
     * @param int|null  $id
     * @param string    $nome
     * @param int       $preco
     */
    public function __construct(?int $id, string $nome, int $preco, array $agendas = [])
    {
        $this->id = $id;
        $this->nome = ucfirst($nome);
        $this->preco = intval($preco);

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
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @return int
     */
    public function getPreco(): int
    {
        return $this->preco;
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
            'nome' => $this->nome,
            'preco' => $this->preco,
            'agendas' => $this->agendas,
        ];
    }
}
