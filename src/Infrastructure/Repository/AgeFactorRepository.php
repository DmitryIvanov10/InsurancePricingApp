<?php
declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\AgeFactor;
use App\Domain\Exception\NotFoundException;
use App\Domain\Interfaces\Repository\AgeFactorRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @codeCoverageIgnore
 */
class AgeFactorRepository extends ServiceEntityRepository implements AgeFactorRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AgeFactor::class);
    }

    /**
     * @inheritDoc
     */
    public function get(int $id): AgeFactor
    {
        /** @var AgeFactor $ageFactor */
        $ageFactor = $this->find($id);

        if ($ageFactor) {
            return $ageFactor;
        }

        throw new NotFoundException(AgeFactor::class, ['id' => $id]);
    }

    /**
     * @inheritDoc
     */
    public function getByAge(int $age): AgeFactor
    {
        return $this->getByType(
            AgeFactor::getTypeByAge($age)
        );
    }

    /**
     * @inheritDoc
     */
    public function getByType(string $type): AgeFactor
    {
        /** @var AgeFactor $ageFactor */
        $ageFactor = $this->findOneBy(['type' => $type]);

        if ($ageFactor) {
            return $ageFactor;
        }

        throw new NotFoundException(AgeFactor::class, ['type' => $type]);
    }
}
