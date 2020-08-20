<?php
declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\AgeFactor;
use App\Domain\DistrictFactor;
use App\Domain\InsuredPeopleAmountFactor;
use App\Domain\PriceModel;

/**
 * @codeCoverageIgnore
 */
class PriceModelFactory
{
    public function create(
        float $price,
        AgeFactor $ageFactor,
        DistrictFactor $districtFactor,
        InsuredPeopleAmountFactor $insuredPeopleAmountFactor
    ): PriceModel {
        return new PriceModel(
            $price,
            $ageFactor,
            $districtFactor,
            $insuredPeopleAmountFactor
        );
    }
}
