<?php
declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\DistrictCode;
use App\Domain\Exception\BadArgumentException;

/**
 * @codeCoverageIgnore
 */
class DistrictCodeFactory
{
    /**
     * @throws BadArgumentException
     */
    public function create(string $value): DistrictCode
    {
        return new DistrictCode($value);
    }
}
