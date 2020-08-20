<?php
declare(strict_types=1);

namespace App\Domain\Interfaces\Repository;

use App\Domain\DistrictCode;
use App\Domain\Exception\NotFoundException;

interface DistrictCodeRepositoryInterface
{
    /**
     * @throws NotFoundException
     */
    public function getByCodeValue(string $value): DistrictCode;

    public function findByCodeValue(string $value): ?DistrictCode;
}
