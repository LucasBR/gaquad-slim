<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class DeleteUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $user_id = (int) $this->resolveArg('id');
        $user = $this->userRepository->findUserOfId($user_id);

        $this->userRepository->delete($user->getId());

        $this->logger->info("Usuário foi excluido.");

        return $this->respondWithData();
    }
}
