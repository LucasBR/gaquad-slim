<?php
declare(strict_types=1);

namespace App\Application\Actions\Quadra;

use Psr\Http\Message\ResponseInterface as Response;

class ViewQuadraAction extends QuadraAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $quadraId = (int) $this->resolveArg('id');
        $quadra = $this->quadraRepository->findQuadraOfId($quadraId);

        $this->logger->info("Quadra of id `${quadraId}` was viewed.");

        return $this->respondWithData($quadra);
    }
}
