<?php
declare(strict_types=1);

namespace App\Domain\Interfaces\Repository;

use App\Domain\DistrictCode;
use App\Domain\DistrictFactor;
use App\Domain\Exception\InfrastructureExceptionInterface;
use App\Domain\Exception\NotFoundException;

interface DistrictFactorRepositoryInterface
{
    /**
     * @throws NotFoundException
     */
    public function get(int $id): DistrictFactor;

    /**
     * @throws NotFoundException
     * @throws InfrastructureExceptionInterface
     */
    public function getByCode(DistrictCode $code): DistrictFactor;
}
