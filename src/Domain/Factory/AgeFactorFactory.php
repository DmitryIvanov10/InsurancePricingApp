<?php
declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\AgeFactor;
use App\Domain\Exception\BadArgumentException;

/**
 * @codeCoverageIgnore
 */
class AgeFactorFactory
{
    /**
     * @throws BadArgumentException
     */
    public function create(int $age): AgeFactor
    {
        $type = AgeFactor::getTypeByAge($age);

        return new AgeFactor($type);
    }
}
