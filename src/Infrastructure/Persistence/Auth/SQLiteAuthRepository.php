<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Auth;

use App\Domain\Auth\Auth;
use App\Domain\Auth\AuthNotFoundException;
use App\Domain\Auth\AuthRepository;
use PDO;

class SQLiteAuthRepository implements AuthRepository
{
    private $salt = 'd8a9w89ahd98j2d82)(D';

    private $connection;

    /**
     * SQLiteAuthRepository constructor.
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
    public function create(int $user_id): Auth
    {
        $stmt = $this->connection->prepare("insert into auth values (null,:user_id,:token,:validade)");
        $stmt->execute([
            'user_id' => $user_id,
            'token' => hash('sha256', microtime() . $this->salt),
            'validade' => (time() + (60 * 60 * 2))
        ]);
        $id = intval($this->connection->lastInsertId());
        
        try {
            return $this->findAuthOfId($id);
            
        } catch(Exception $e) {
            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $token)
    {
        $stmt = $this->connection->prepare("delete from auth where token=:token");
        $stmt->execute(['token' => $token]);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function findAuthOfId(int $id): Auth
    {
        $stmt = $this->connection->prepare("select * from auth where id=:id");
        $stmt->execute(['id' => $id]);
        $auth = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$auth)
            throw new AuthNotFoundException();

        return new Auth(intval($auth['id']),intval($auth['user_id']),$auth['token'],intval($auth['validade']));
    }

    /**
     * {@inheritdoc}
     */
    public function findAuthByUserId(int $user_id): Auth
    {
        $stmt = $this->connection->prepare("select * from auth where user_id=:user_id");
        $stmt->execute(['user_id' => $user_id]);
        $auth = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$auth)
            throw new AuthNotFoundException();
        
        return new Auth(intval($auth['id']),intval($auth['user_id']),$auth['token'],intval($auth['validade']));
    }

    /**
     * {@inheritdoc}
     */
    public function findAuthByValidTokenId(string $token): Auth
    {
        $stmt = $this->connection->prepare("select * from auth");
        $stmt->execute();
        $auths = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $tokenExpirado = true;
        $auth = [];
        foreach($auths as $checkAuth){

            if ( time() > intval($checkAuth['validade']) ){
                $this->delete($checkAuth['token']);
            }else{
                if ( strval($checkAuth['token']) == $token ){
                    $tokenExpirado = false;
                    $auth = $checkAuth;
                }
            }
        }
        
        if (!$auths || $tokenExpirado)
            throw new AuthNotFoundException();
        
        return new Auth(intval($auth['id']),intval($auth['user_id']),$auth['token'],intval($auth['validade']));
    }
}
