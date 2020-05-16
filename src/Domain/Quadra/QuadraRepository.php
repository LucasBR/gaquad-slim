<?php
declare(strict_types=1);

namespace App\Domain\Quadra;

interface QuadraRepository
{
    /**
     * @return Quadra[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return Quadra
     * @throws QuadraNotFoundException
     */
    public function findQuadraOfId(int $id): Quadra;
}
