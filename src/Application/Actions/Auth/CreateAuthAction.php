<?php
declare(strict_types=1);

namespace App\Application\Actions\Auth;

use Psr\Http\Message\ResponseInterface as Response;

class CreateAuthAction extends AuthAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $parsedBody = $this->request->getParsedBody();

        $user = $this->userRepository->findUserByEmailAndSenha(
            strval($parsedBody['email']),
            strval($parsedBody['senha']));

        $auth = $this->authRepository->create($user->getId());

        $this->logger->info("Autenticação foi criado.");

        return $this->respondWithData($auth);
    }
}
