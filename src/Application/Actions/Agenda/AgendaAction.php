<?php
declare(strict_types=1);

namespace App\Application\Actions\Agenda;

use App\Application\Actions\Action;
use App\Domain\Agenda\AgendaRepository;
use Psr\Log\LoggerInterface;

abstract class AgendaAction extends Action
{
    /**
     * @var AgendaRepository
     */
    protected $agendaRepository;

    /**
     * @param LoggerInterface $logger
     * @param AgendaRepository  $agendaRepository
     */
    public function __construct(LoggerInterface $logger, AgendaRepository $agendaRepository)
    {
        parent::__construct($logger);
        $this->agendaRepository = $agendaRepository;
    }
}
