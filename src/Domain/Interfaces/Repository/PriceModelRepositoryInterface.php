<?php
declare(strict_types=1);

namespace App\Domain\Interfaces\Repository;

use App\Domain\Exception\InfrastructureExceptionInterface;
use App\Domain\Exception\NotFoundException;
use App\Domain\Interfaces\FactorQueryInterface;
use App\Domain\PriceModel;

interface PriceModelRepositoryInterface
{
    /**
     * @throws InfrastructureExceptionInterface
     */
    public function save(PriceModel $priceModel): PriceModel;

    /**
     * @throws NotFoundException
     */
    public function get(int $id): PriceModel;

    /**
     * @return PriceModel[]
     */
    public function findByFactors(FactorQueryInterface $factorQuery): array;
}
