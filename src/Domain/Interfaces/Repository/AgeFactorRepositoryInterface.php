<?php
declare(strict_types=1);

namespace App\Domain\Interfaces\Repository;

use App\Domain\AgeFactor;
use App\Domain\Exception\BadArgumentException;
use App\Domain\Exception\NotFoundException;

interface AgeFactorRepositoryInterface
{
    /**
     * @throws NotFoundException
     */
    public function get(int $id): AgeFactor;

    /**
     * @throws NotFoundException
     * @throws BadArgumentException
     */
    public function getByAge(int $age): AgeFactor;

    /**
     * @throws NotFoundException
     */
    public function getByType(string $type): AgeFactor;
}
