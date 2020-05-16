<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class CreateUserAgendaAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $user_id = (int) $this->resolveArg('id');
        $user = $this->userRepository->findUserOfId($user_id);

        $parsedBody = $this->request->getParsedBody();

        $agenda = $this->agendaRepository->create(
            $user->getId(),
            intval($parsedBody['quadra_id']),
            strval($parsedBody['data']),
            json_encode($parsedBody['horas']));

            $this->logger->info("Agendamento de Usuário foi criado.");

        return $this->respondWithData($agenda);
    }
}
