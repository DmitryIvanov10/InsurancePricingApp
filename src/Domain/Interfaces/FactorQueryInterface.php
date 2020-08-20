<?php
declare(strict_types=1);

namespace App\Domain\Interfaces;

interface FactorQueryInterface
{
    /**
     * @return FactorInterface[]
     */
    public function getFactors(): array;
}
