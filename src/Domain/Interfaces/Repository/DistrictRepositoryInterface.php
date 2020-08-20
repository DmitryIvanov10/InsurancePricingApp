<?php
declare(strict_types=1);

namespace App\Domain\Interfaces\Repository;

use App\Domain\District;
use App\Domain\Exception\NotFoundException;

interface DistrictRepositoryInterface
{
    /**
     * @throws NotFoundException
     */
    public function getByZip(int $zip): District;
}
