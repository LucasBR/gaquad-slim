<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class ListUserAgendaAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $id = (int) $this->resolveArg('id');
        $user = $this->userRepository->findUserOfId($id);

        $agendas = $this->agendaRepository->findAgendaByUserId($id);
        $user->setAgendas($agendas);

        $this->logger->info("Agenda do Usuario id `${id}` foi visualizado.");

        return $this->respondWithData($user);
    }
}
