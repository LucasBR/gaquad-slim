<?php
declare(strict_types=1);

namespace App\Domain\User;

interface UserRepository
{
    /**
     * @return User[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     */
    public function findUserOfId(int $id): User;

    /**
     * @param string $email
     * @param string $senha
     * @return User
     * @throws UserNotFoundException
     */
    public function findUserByEmailAndSenha(string $email, string $senha): User;
}
