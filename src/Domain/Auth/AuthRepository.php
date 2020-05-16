<?php
declare(strict_types=1);

namespace App\Domain\Auth;

interface AuthRepository
{
    /**
     * @param int $user_id
     * @return Auth
     */
    public function create(int $user_id): Auth;
    
    /**
     * @param string $token
     * @throws AuthNotFoundException
     */
    public function delete(string $token);

    /**
     * @return Auth[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return Auth
     * @throws AuthNotFoundException
     */
    public function findAuthOfId(int $id): Auth;
    
    /**
     * @param int $user_id
     * @return Auth
     * @throws AuthNotFoundException
     */
    public function findAuthByUserId(int $user_id): Auth;

    /**
     * @param string $token
     * @return Auth
     * @throws AuthNotFoundException
     */
    public function findAuthByValidTokenId(string $token): Auth;
    
    
}
