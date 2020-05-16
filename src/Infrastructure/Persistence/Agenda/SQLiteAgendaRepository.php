<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Agenda;

use App\Domain\Agenda\Agenda;
use App\Domain\Agenda\AgendaNotFoundException;
use App\Domain\Agenda\AgendaRepository;
use PDO;

class SQLiteAgendaRepository implements AgendaRepository
{

    private $connection;

    /**
     * SQLiteAgendaRepository constructor.
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
    public function create(int $user_id, int $quadra_id, string $data, string $horas): Agenda
    {
        $stmt = $this->connection->prepare("insert into agendas values (null,:user_id,:quadra_id,:data,:horas)");
        $stmt->execute([
            'user_id' => $user_id,
            'quadra_id' => $quadra_id,
            'data' => $data,
            'horas' => $horas
        ]);
        $id = intval($this->connection->lastInsertId());
        
        try {
            return $this->findAgendaOfId($id);
            
        } catch(Exception $e) {
            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function update(int $id, int $user_id, int $quadra_id, string $data, string $horas): Agenda
    {
        $sql="update agendas set user_id=:user_id, quadra_id=:quadra_id, data=:data, horas=:horas where id=:id";
        $stmt = $this->connection->prepare($sql);
        $execute= $stmt->execute([
            'user_id' => $user_id,
            'quadra_id' => $quadra_id,
            'data' => $data,
            'horas' => $horas
        ]);
        
        return $this->findAgendaOfId($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        $stmt = $this->connection->prepare("select * from agendas");
        $stmt->execute();
        $agendasList = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $agendas = [];
        foreach($agendasList as $agenda){
            $agendas []= new Agenda(
                intval($agenda['id']),
                intval($agenda['user_id']),
                intval($agenda['quadra_id']),
                $agenda['data'],$agenda['horas']);
        }

        return $agendas;
    }

    /**
     * {@inheritdoc}
     */
    public function findAgendaOfId(int $id): Agenda
    {
        $stmt = $this->connection->prepare("select * from agendas where id=:id");
        $stmt->execute(['id' => $id]);
        $agenda = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$agenda)
            throw new AgendaNotFoundException();

        return new Agenda(
            intval($agenda['id']),
            intval($agenda['user_id']),
            intval($agenda['quadra_id']),
            $agenda['data'],$agenda['horas']);
    }

    /**
     * {@inheritdoc}
     */
    public function findAgendaByUserId(int $user_id): array
    {
        $stmt = $this->connection->prepare("select * from agendas where user_id=:user_id");
        $stmt->execute(['user_id' => $user_id]);
        $agendasList = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $agendas = [];
        foreach($agendasList as $agenda){
            $agendas []= new Agenda(
                intval($agenda['id']),
                intval($agenda['user_id']),
                intval($agenda['quadra_id']),
                $agenda['data'],$agenda['horas']);
        }

        return $agendas;
    }

    /**
     * {@inheritdoc}
     */
    public function findAgendaByQuadraId(int $quadra_id): array
    {
        $stmt = $this->connection->prepare("select * from agendas where quadra_id=:quadra_id");
        $stmt->execute(['quadra_id' => $quadra_id]);
        $agendasList = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $agendas = [];
        foreach($agendasList as $agenda){
            $agendas []= new Agenda(
                intval($agenda['id']),
                intval($agenda['quadra_id']),
                intval($agenda['quadra_id']),
                $agenda['data'],$agenda['horas']);
        }

        return $agendas;
    }
    
    /**
     * {@inheritdoc}
     */
    public function delete(int $id)
    {
        $stmt = $this->connection->prepare("delete from agendas where id=:id");
        $stmt->execute(['id' => $id]);
    }    
}
