<?php
declare(strict_types=1);

namespace App\Domain;

use App\Domain\Interfaces\FactorQueryInterface;

/**
 * @codeCoverageIgnore
 */
final class FactorQuery implements FactorQueryInterface
{
    /**
     * @inheritDoc
     */
    public function getFactors(): array
    {
        return [];
    }
}
