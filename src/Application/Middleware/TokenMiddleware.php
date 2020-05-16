<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use App\Domain\Auth\AuthRepository;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

use Slim\Exception\HttpUnauthorizedException;

class TokenMiddleware implements Middleware
{
    /**
     * @var AuthRepository
     */
    protected $authRepository;

    public function __construct(AuthRepository $authRepository){
        $this->authRepository = $authRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $authorization = $request->getHeaderLine('Authorization');
        $token = trim(str_replace('Bearer', '', $authorization));
        
        if (!$token)
            throw new HttpUnauthorizedException($request);

        try {
            $auth = $this->authRepository->findAuthByValidTokenId($token);
            $request = $request->withAttribute('user_id', $auth->getUserId());

        } catch (\Throwable $th) {
            throw new HttpUnauthorizedException($request);
        }

        return $handler->handle($request);
    }
}
