<?php
declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\DistrictCode;
use App\Domain\DistrictFactor;

/**
 * @codeCoverageIgnore
 */
class DistrictFactorFactory
{
    public function create(DistrictCode $districtCode): DistrictFactor
    {
        return new DistrictFactor($districtCode);
    }
}
