<?php
declare(strict_types=1);

namespace App\Domain\Quadra;

use App\Domain\DomainException\DomainRecordNotFoundException;

class QuadraNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'A quadra que você solicitou não existe.';
}
