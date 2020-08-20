<?php
declare(strict_types=1);

namespace App\Domain;

use App\Domain\Interfaces\FactorInterface;
use App\Domain\Interfaces\FactorQueryInterface;

/**
 * TODO cover with unit test
 */
final class FactorQueryDecorator implements FactorQueryInterface
{
    private FactorQueryInterface $factorQuery;
    private FactorInterface $factor;

    public function __construct(FactorQueryInterface $factorQuery, FactorInterface $factor)
    {
        $this->factorQuery = $factorQuery;
        $this->factor = $factor;
    }

    /**
     * @inheritDoc
     */
    public function getFactors(): array
    {
        return [
            $this->factor->getFactorName() => $this->factor
        ] + $this->factorQuery->getFactors();
    }
}
