<?php
declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\District;
use App\Domain\DistrictCode;
use App\Domain\Exception\BadArgumentException;

/**
 * @codeCoverageIgnore
 */
class DistrictFactory
{
    /**
     * @throws BadArgumentException
     */
    public function create(int $zip, string $city, DistrictCode $code)
    {
        return new District($zip, $city, $code);
    }
}
