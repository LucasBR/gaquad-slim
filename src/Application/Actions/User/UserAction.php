<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Domain\User\UserRepository;
use App\Domain\Agenda\AgendaRepository;
use Psr\Log\LoggerInterface;

abstract class UserAction extends Action
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var AgendaRepository
     */
    protected $agendaRepository;

    /**
     * @param LoggerInterface $logger
     * @param UserRepository  $userRepository
     */
    public function __construct(LoggerInterface $logger, UserRepository $userRepository, AgendaRepository $agendaRepository)
    {
        parent::__construct($logger);
        $this->userRepository = $userRepository;
        $this->agendaRepository = $agendaRepository;
    }
}
