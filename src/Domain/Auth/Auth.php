<?php
declare(strict_types=1);

namespace App\Domain\Auth;

use JsonSerializable;

class Auth implements JsonSerializable
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var string
     */
    private $user_id;

    /**
     * @var string
     */
    private $token;

    /**
     * @var int
     */
    private $validade;

    /**
     * @param int|null  $id
     * @param int       $user_id
     * @param string    $token
     * @param int       $validade
     */
    public function __construct(?int $id, int $user_id, string $token, int $validade)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->token = $token;
        $this->validade = $validade;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getValidade(): string
    {
        return $this->validade;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'token' => $this->token,
            'validade' => $this->validade,
        ];
    }
}
