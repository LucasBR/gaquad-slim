<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class EditUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');
        $user = $this->userRepository->findUserOfId($userId);

        
        $parsedBody = $this->request->getParsedBody();
        if (!isset($parsedBody['senha']))
            $parsedBody['senha'] = "";

        $user = $this->userRepository->update(
            $userId,
            strval($parsedBody['email']),
            strval($parsedBody['nome']),
            strval($parsedBody['cpf']),
            strval($parsedBody['senha']),
            boolval($parsedBody['admin'])
        );

        $this->logger->info("Usuário foi atualizado.");

        return $this->respondWithData($user);
    }
}
