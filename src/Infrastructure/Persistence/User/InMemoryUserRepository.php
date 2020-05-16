<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use DI\ContainerBuilder;

class InMemoryUserRepository implements UserRepository
{
    /**
     * @var User[]
     */
    private $users;

    private $salt = "9afs8w98fjaf0jwaf90";

    /**
     * InMemoryUserRepository constructor.
     *
     * @param array|null $users
     */
    public function __construct(array $users = null)
    {
        $this->users = $users ?? [
            1 => new User(1, 'bill.gates@mail.com', 'Bill Gates', '000.000.000.01', crypt("1qwe", $this->salt)),
            2 => new User(2, 'steve.jobs@mail.com', 'Steve Jobs', '000.000.000.02', crypt("2qwe", $this->salt)),
            3 => new User(3, 'mark.zuckerberg@mail.com', 'Mark Zuckerberg', '000.000.000.03', crypt("3qwe", $this->salt)),
            4 => new User(4, 'evan.spiegel@mail.com', 'Evan Spiegel', '000.000.000.04', crypt("4qwe", $this->salt)),
            5 => new User(5, 'jack.dorsey@mail.com', 'Jack Dorsey', '000.000.000.05', crypt("5qwe", $this->salt)),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->users);
    }

    /**
     * {@inheritdoc}
     */
    public function findUserOfId(int $id): User
    {
        if (!isset($this->users[$id])) {
            throw new UserNotFoundException();
        }

        return $this->users[$id];
    }

    /**
     * {@inheritdoc}
     */
    public function findUserByEmailAndSenha(string $email, string $senha): User
    {
        foreach ($this->users as $user)
            if (($user->getEmail() == $email)&&($user->getSenha() == crypt($senha, $this->salt)))
                return $this->users[$user->getId()];
        
        throw new UserNotFoundException();
    }
}
