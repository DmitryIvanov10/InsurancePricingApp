<?php
declare(strict_types=1);

namespace App\Domain\Interfaces\Repository;

use App\Domain\Exception\BadArgumentException;
use App\Domain\Exception\NotFoundException;
use App\Domain\InsuredPeopleAmountFactor;

interface InsuredPeopleAmountFactorRepositoryInterface
{
    /**
     * @throws NotFoundException
     */
    public function get(int $id): InsuredPeopleAmountFactor;

    /**
     * @throws NotFoundException
     * @throws BadArgumentException
     */
    public function getByType(string $type): InsuredPeopleAmountFactor;
}
