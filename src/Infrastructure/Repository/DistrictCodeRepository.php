<?php
declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\DistrictCode;
use App\Domain\Exception\NotFoundException;
use App\Domain\Interfaces\Repository\DistrictCodeRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @codeCoverageIgnore
 */
class DistrictCodeRepository extends ServiceEntityRepository implements DistrictCodeRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DistrictCode::class);
    }

    /**
     * @inheritDoc
     */
    public function getByCodeValue(string $value): DistrictCode
    {
        $districtCode = $this->findByCodeValue($value);

        if ($districtCode) {
            return $districtCode;
        }

        throw new NotFoundException(DistrictCode::class, ['value' => $value]);
    }

    /**
     * @inheritDoc
     */
    public function findByCodeValue(string $value): ?DistrictCode
    {
        /** @var DistrictCode $districtCode */
        $districtCode = $this->findOneBy(['value' => $value]);

        return $districtCode;
    }
}
