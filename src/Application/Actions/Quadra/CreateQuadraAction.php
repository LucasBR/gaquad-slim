<?php
declare(strict_types=1);

namespace App\Application\Actions\Quadra;

use Psr\Http\Message\ResponseInterface as Response;

class CreateQuadraAction extends QuadraAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $parsedBody = $this->request->getParsedBody();
        
        $quadra = $this->quadraRepository->create(
            strval($parsedBody['nome']),
            intval($parsedBody['preco']));

        $this->logger->info("Quadra foi criada.");

        return $this->respondWithData($quadra);
    }
}
