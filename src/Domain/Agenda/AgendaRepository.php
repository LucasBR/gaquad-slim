<?php
declare(strict_types=1);

namespace App\Domain\Agenda;

interface AgendaRepository
{
    /**
     * @return Agenda[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return Agenda
     * @throws AgendaNotFoundException
     */
    public function findAgendaOfId(int $id): Agenda;

    /**
     * @param int $user_id
     * @return Agenda[]
     */
    public function findAgendaByUserId(int $user_id): array;

    /**
     * @param int $quadra_id
     * @return Agenda[]
     */
    public function findAgendaByQuadraId(int $quadra_id): array;
}
