<?php
declare(strict_types=1);

namespace App\Domain\Agenda;

use App\Domain\DomainException\DomainRecordNotFoundException;

class AgendaNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'A agenda que você solicitou não existe.';
}
