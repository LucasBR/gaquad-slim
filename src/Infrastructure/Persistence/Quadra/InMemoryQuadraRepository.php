<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Quadra;

use App\Domain\Quadra\Quadra;
use App\Domain\Quadra\QuadraNotFoundException;
use App\Domain\Quadra\QuadraRepository;

class InMemoryQuadraRepository implements QuadraRepository
{
    /**
     * @var Quadra[]
     */
    private $quadras;

    /**
     * InMemoryQuadraRepository constructor.
     *
     * @param array|null $quadras
     */
    public function __construct(array $quadras = null)
    {
        $this->quadras = $quadras ?? [
            1 => new Quadra(1, 'Futebol 5', '150'),
            2 => new Quadra(2, 'Futebol 7', '200'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->quadras);
    }

    /**
     * {@inheritdoc}
     */
    public function findQuadraOfId(int $id): Quadra
    {
        if (!isset($this->quadras[$id])) {
            throw new QuadraNotFoundException();
        }

        return $this->quadras[$id];
    }
}
