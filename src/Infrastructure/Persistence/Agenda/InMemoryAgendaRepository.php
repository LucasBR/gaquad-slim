<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Agenda;

use App\Domain\Agenda\Agenda;
use App\Domain\Agenda\AgendaNotFoundException;
use App\Domain\Agenda\AgendaRepository;

class InMemoryAgendaRepository implements AgendaRepository
{
    /**
     * @var Agenda[]
     */
    private $agendas;

    /**
     * InMemoryAgendaRepository constructor.
     *
     * @param array|null $agendas
     */
    public function __construct(array $agendas = null)
    {
        $this->agendas = $agendas ?? [
            1 => new Agenda(1, 1, 1, '2010-10-01', '[10,11]'),
            2 => new Agenda(2, 1, 1, '2010-10-02', '[10,11]'),
            3 => new Agenda(3, 3, 2, '2010-08-05', '[12,13]'),
            4 => new Agenda(4, 4, 1, '2010-03-01', '[8,9]'),
            5 => new Agenda(5, 4, 2, '2010-02-01', '[20,21]'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->agendas);
    }

    /**
     * {@inheritdoc}
     */
    public function findAgendaOfId(int $id): Agenda
    {
        if (!isset($this->agendas[$id])) {
            throw new AgendaNotFoundException();
        }

        return $this->agendas[$id];
    }

    /**
     * {@inheritdoc}
     */
    public function findAgendaByUserId(int $user_id): array
    {
        $agendas = [];
        foreach ($this->agendas as $agenda)
            if ($agenda->getUserId() == $user_id) $agendas []= $agenda;

        return array_values($agendas);
    }

    /**
     * {@inheritdoc}
     */
    public function findAgendaByQuadraId(int $quadra_id): array
    {
        $agendas = [];
        foreach ($this->agendas as $agenda)
            if ($agenda->getQuadraId() == $quadra_id) $agendas []= $agenda;

        return array_values($agendas);
    }
    
    
}
