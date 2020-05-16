<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Auth;

use App\Domain\Auth\Auth;
use App\Domain\Auth\AuthNotFoundException;
use App\Domain\Auth\AuthRepository;

class InMemoryAuthRepository implements AuthRepository
{
    /**
     * @var Auth[]
     */
    private $auths;

    /**
     * InMemoryAuthRepository constructor.
     *
     * @param array|null $auths
     */
    public function __construct(array $auths = null)
    {
        $this->auths = $auths ?? [
            1 => new Auth(1, 1, hash('sha256', microtime()), '1587094765'),
            2 => new Auth(2, 2, "376cb25564c48d68742f5db32d4e2fbe9940379a83c3f70abec010ce9462a244", '1587994283'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(int $user_id): Auth
    {
        $this->auths [3]= new Auth(3, $user_id, hash('sha256', microtime()), '1587093228');

        return $this->auths[3];
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $token)
    {
        $authId = 0;
        foreach ($this->auths as $auth)
            if ($auth->getToken() == $token)
                $authId = $auth->getId();
        
        if (!$authId)
            throw new AuthNotFoundException();
        
        unset( $this->auths[$authId] );
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->auths);
    }

    /**
     * {@inheritdoc}
     */
    public function findAuthOfId(int $id): Auth
    {
        if (!isset($this->auths[$id])) {
            throw new AuthNotFoundException();
        }

        return $this->auths[$id];
    }

    /**
     * {@inheritdoc}
     */
    public function findAuthByUserId(int $user_id): Auth
    {
        foreach ($this->auths as $auth)
            if ($agenda->getUserId() == $user_id)
                return $this->auths[$auth->getId()];
        
        throw new AuthNotFoundException();
    }
}
