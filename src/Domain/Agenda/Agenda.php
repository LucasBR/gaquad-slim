<?php
declare(strict_types=1);

namespace App\Domain\Agenda;

use JsonSerializable;

class Agenda implements JsonSerializable
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var int|null
     */
    private $user_id;

    /**
     * @var int|null
     */
    private $quadra_id;

    /**
     * @var string
     */
    private $data;

    /**
     * @var string
     */
    private $horas;

    /**
     * @param int|null  $id 
     * @param int|null  $user_id
     * @param int|null  $quadra_id
     * @param string    $data
     * @param string    $horas
     */
    public function __construct(?int $id, int $user_id, int $quadra_id, string $data, string $horas)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->quadra_id = $quadra_id;
        $this->data = $data;
        $this->horas = $horas;
    }
    
    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    /**
     * @return int|null
     */
    public function getQuadraId(): int
    {
        return $this->quadra_id;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        $dataPtBr = new \DateTime($this->data);
        return $dataPtBr->format("d/m/Y");
    }

    /**
     * @return string
     */
    public function getHoras(): array
    {
        return json_decode($this->horas);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'quadra_id' => $this->quadra_id,
            'data' => $this->getData(),
            'horas' => $this->getHoras(),
        ];
    }
}
