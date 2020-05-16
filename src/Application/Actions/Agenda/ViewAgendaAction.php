<?php
declare(strict_types=1);

namespace App\Application\Actions\Agenda;

use Psr\Http\Message\ResponseInterface as Response;

class ViewAgendaAction extends AgendaAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $agendaId = (int) $this->resolveArg('id');
        $agenda = $this->agendaRepository->findAgendaOfId($agendaId);

        $this->logger->info("Agenda of id `${agendaId}` was viewed.");

        return $this->respondWithData($agenda);
    }
}
