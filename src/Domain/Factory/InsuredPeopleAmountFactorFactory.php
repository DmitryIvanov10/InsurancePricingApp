<?php
declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\Exception\BadArgumentException;
use App\Domain\InsuredPeopleAmountFactor;

/**
 * @codeCoverageIgnore
 */
class InsuredPeopleAmountFactorFactory
{
    /**
     * @throws BadArgumentException
     */
    public function create(string $type): InsuredPeopleAmountFactor
    {
        return new InsuredPeopleAmountFactor($type);
    }
}
