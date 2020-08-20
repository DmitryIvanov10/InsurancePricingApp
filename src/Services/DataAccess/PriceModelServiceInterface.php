<?php
declare(strict_types=1);

namespace App\Services\DataAccess;

use App\Domain\Exception\BadArgumentException;
use App\Domain\Exception\InfrastructureExceptionInterface;
use App\Domain\Exception\NotFoundException;
use App\Domain\PriceModel;
use App\Domain\ValueObject\PriceModelQuery;
use App\Domain\ValueObject\PriceModelSearchQuery;

interface PriceModelServiceInterface
{
    /**
     * @return PriceModel[]
     * @throws NotFoundException
     * @throws BadArgumentException
     * @throws InfrastructureExceptionInterface
     */
    public function getPriceModel(PriceModelSearchQuery $priceQuery): array;

    /**
     * @throws NotFoundException
     * @throws InfrastructureExceptionInterface
     */
    public function createPriceModel(PriceModelQuery $priceModelQuery): PriceModel;

    /**
     * @throws NotFoundException
     * @throws InfrastructureExceptionInterface
     */
    public function updatePriceModel(int $id, float $price): PriceModel;
}
