<?php
declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Application\Actions\Action;
use App\Domain\Auth\AuthRepository;
use App\Domain\User\UserRepository;
use Psr\Log\LoggerInterface;

abstract class AuthAction extends Action
{
    /**
     * @var AuthRepository
     */
    protected $authRepository;
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @param LoggerInterface $logger
     * @param AuthRepository  $authRepository
     * @param UserRepository  $userRepository
     */
    public function __construct(LoggerInterface $logger, AuthRepository $authRepository, UserRepository $userRepository)
    {
        parent::__construct($logger);
        $this->authRepository = $authRepository;
        $this->userRepository = $userRepository;
    }
}
