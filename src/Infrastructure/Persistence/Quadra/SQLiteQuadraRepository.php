<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Quadra;

use App\Domain\Quadra\Quadra;
use App\Domain\Quadra\QuadraNotFoundException;
use App\Domain\Quadra\QuadraRepository;
use PDO;

class SQLiteQuadraRepository implements QuadraRepository
{
    private $connection;

    /**
     * SQLiteQuadraRepository constructor.
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
    public function create(string $nome, int $preco, array $agendas = []): Quadra
    {
        $stmt = $this->connection->prepare("insert into quadras values (null,:nome,:preco)");
        $stmt->execute([
            'nome' => $nome,
            'preco' => $preco
        ]);
        $id = intval($this->connection->lastInsertId());
        
        try {
            return $this->findQuadraOfId($id);
            
        } catch(Exception $e) {
            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        $stmt = $this->connection->prepare("select * from quadras");
        $stmt->execute();
        $quadrasList = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $quadras = [];
        foreach($quadrasList as $quadra){
            $quadras []= new Quadra(intval($quadra['id']),$quadra['nome'],intval($quadra['preco']));
        }

        return $quadras;
    }

    /**
     * {@inheritdoc}
     */
    public function findQuadraOfId(int $id): Quadra
    {
        $stmt = $this->connection->prepare("select * from quadras where id=:id");
        $stmt->execute(['id' => $id]);
        $quadra = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$quadra)
            throw new QuadraNotFoundException();

        return new Quadra(intval($quadra['id']),$quadra['nome'],intval($quadra['preco']));
    }
}
