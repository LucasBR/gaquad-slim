<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use DI\ContainerBuilder;
use PDO;

class SQLiteUserRepository implements UserRepository
{
    private $salt = "9afs8w98fjaf0jwaf90";

    private $connection;

    /**
     * SQLiteUserRepository constructor.
     *
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * {@inheritdoc}
     */
    public function create(string $email, string $nome, string $cpf, string $senha, bool $admin, array $agendas = []): User
    {
        $stmt = $this->connection->prepare("insert into users values (null,:email,:nome,:cpf,:senha,:admin)");
        $stmt->execute([
            'email' => $email,
            'nome' => $nome,
            'cpf' => $cpf,
            'senha' => crypt($senha,$this->salt),
            'admin' => $admin
        ]);
        $id = intval($this->connection->lastInsertId());
        
        return $this->findUserOfId($id);
    }

    /**
     * {@inheritdoc}
     */
    public function update(int $id, string $email, string $nome, string $cpf, string $senha, bool $admin, array $agendas = []): User
    {
        $senhaReplace = (!$senha) ? '' : 'senha=:senha,';
        
        $sql = "update users set email=:email, nome=:nome, cpf=:cpf, [%senha%] admin=:admin where id=:id";
        $sql= str_replace(['[%senha%]'],[$senhaReplace],$sql);
        
        $stmt = $this->connection->prepare($sql);
        $bind = [
            'email' => $email,
            'nome' => $nome,
            'cpf' => $cpf,
            
            'admin' => $admin,
            'id' => $id,
        ];
        if ($senha) $bind['senha'] = crypt($senha,$this->salt);
        $execute = $stmt->execute($bind);
    
        return $this->findUserOfId($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        $stmt = $this->connection->prepare("select * from users");
        $stmt->execute();
        $usersList = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach($usersList as $user){
            $users []= new User(intval($user['id']),$user['email'],$user['nome'],$user['cpf'],'',boolval($user['admin']));
        }

        return $users;
    }

    /**
     * {@inheritdoc}
     */
    public function findUserOfId(int $id): User
    {
        $stmt = $this->connection->prepare("select * from users where id=:id");
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user)
            throw new UserNotFoundException();

        return new User(intval($user['id']),$user['email'],$user['nome'],$user['cpf'],'',boolval($user['admin']));
    }

    /**
     * {@inheritdoc}
     */
    public function findUserByEmailAndSenha(string $email, string $senha): User
    {
        $stmt = $this->connection->prepare("select * from users where email=:email and senha=:senha");
        $stmt->execute([
            'email' => $email,
            'senha' => crypt($senha, $this->salt)
        ]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user)
            throw new UserNotFoundException();
        
        return new User(intval($user['id']),$user['email'],$user['nome'],$user['cpf'],'',boolval($user['admin']));
    }

    /**
     * {@inheritdoc}
     */
    public function delete(int $id)
    {
        try {
            $this->connection->beginTransaction();

            $stmt = $this->connection->prepare("delete from users where id=:id");
            $stmt->execute(['id' => $id]);
            $stmt = $this->connection->prepare("delete from agendas where user_id=:user_id");
            $stmt->execute(['user_id' => $id]);

            $this->connection->commit();

        } catch (\Throwable $th) {
            $this->connection->rollBack();

            throw $th;
        }
    }
}
