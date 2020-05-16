<?php
declare(strict_types=1);

namespace App\Application\Actions\Quadra;

use Psr\Http\Message\ResponseInterface as Response;

class ListQuadrasAction extends QuadraAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $quadras = $this->quadraRepository->findAll();

        $this->logger->info("Quadras list was viewed.");

        return $this->respondWithData($quadras);
    }
}
