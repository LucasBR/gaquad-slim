<?php
declare(strict_types=1);

namespace App\Application\Actions\Auth;

use Psr\Http\Message\ResponseInterface as Response;

class DeleteAuthAction extends AuthAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $token = $this->resolveArg('token');
        $this->authRepository->delete($token);

        $this->logger->info("Autenticação token `${token}` foi excluída.");

        return $this->respondWithData();
    }
}
