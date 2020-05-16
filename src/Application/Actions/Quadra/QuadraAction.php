<?php
declare(strict_types=1);

namespace App\Application\Actions\Quadra;

use App\Application\Actions\Action;
use App\Domain\Quadra\QuadraRepository;
use App\Domain\Agenda\AgendaRepository;
use Psr\Log\LoggerInterface;

abstract class QuadraAction extends Action
{
    /**
     * @var QuadraRepository
     */
    protected $quadraRepository;

    /**
     * @var AgendaRepository
     */
    protected $agendaRepository;

    /**
     * @param LoggerInterface $logger
     * @param QuadraRepository  $quadraRepository
     */
    public function __construct(LoggerInterface $logger, QuadraRepository $quadraRepository, AgendaRepository $agendaRepository)
    {
        parent::__construct($logger);
        $this->quadraRepository = $quadraRepository;
        $this->agendaRepository = $agendaRepository;
    }
}
