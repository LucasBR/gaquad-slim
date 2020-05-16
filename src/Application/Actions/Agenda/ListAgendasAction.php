<?php
declare(strict_types=1);

namespace App\Application\Actions\Agenda;

use Psr\Http\Message\ResponseInterface as Response;

class ListAgendasAction extends AgendaAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $agendas = $this->agendaRepository->findAll();

        $this->logger->info("Agendas list was viewed.");

        return $this->respondWithData($agendas);
    }
}
