<?php
declare(strict_types=1);

namespace App\Application\Actions\Quadra;

use Psr\Http\Message\ResponseInterface as Response;

class ListQuadraAgendaAction extends QuadraAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $id = (int) $this->resolveArg('id');
        $quadra = $this->quadraRepository->findQuadraOfId($id);

        $agendas = $this->agendaRepository->findAgendaByQuadraId($id);
        $quadra->setAgendas($agendas);

        $this->logger->info("Agenda da Quadra id `${id}` foi visualizado.");

        return $this->respondWithData($quadra);
    }
}
