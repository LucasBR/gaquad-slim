<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class CreateUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $parsedBody = $this->request->getParsedBody();
        
        $user = $this->userRepository->create(
            strval($parsedBody['email']),
            strval($parsedBody['nome']),
            strval($parsedBody['cpf']),
            strval($parsedBody['senha']),
            boolval($parsedBody['admin'])
        );

        $this->logger->info("Usuário foi criado.");

        return $this->respondWithData($user);
    }
}
