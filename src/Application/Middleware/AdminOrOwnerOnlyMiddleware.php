<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use App\Domain\User\UserRepository;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

use Slim\Exception\HttpUnauthorizedException;

class AdminOrOwnerOnlyMiddleware implements Middleware
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        
        $userId= $request->getAttribute('user_id');
        
        if (!$userId)
            throw new HttpUnauthorizedException($request);
        
        if (!$handler->getArgument('id'))
            throw new HttpUnauthorizedException($request);            
        
        $user = $this->userRepository->findUserOfId($userId);

        if ($user->getAdmin() || (intval($userId) == intval($handler->getArgument('id'))) ) 
            return $handler->handle($request);
        
        throw new HttpUnauthorizedException($request);
    }
}
