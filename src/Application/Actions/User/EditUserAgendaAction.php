<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

use Slim\Exception\HttpUnauthorizedException;

class EditUserAgendaAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $user_id = (int) $this->resolveArg('id');
        $user = $this->userRepository->findUserOfId($user_id);

        $agenda_id = (int) $this->resolveArg('agenda_id');
        $agenda = $this->agendaRepository->findAgendaOfId($agenda_id);

        if ($agenda->getUserId() != $user->getId()){

            $userActionId = $this->request->getAttribute('user_id');
            $userAction = $this->userRepository->findUserOfId($userActionId);
            
            if (!$userAction->getAdmin())
                throw new HttpUnauthorizedException($this->request);
        }
        
        $parsedBody = $this->request->getParsedBody();
        var_dump($agenda->getId());
        var_dump($user->getId());
        print_r($parsedBody);
        
        $agenda = $this->agendaRepository->update(
            $agenda->getId(),
            $user->getId(),
            intval($parsedBody['quadra_id']),
            strval($parsedBody['data']),
            json_encode($parsedBody['horas']));

            $this->logger->info("Agendamento de Usuário foi atualizado.");

        return $this->respondWithData($agenda);
    }
}
