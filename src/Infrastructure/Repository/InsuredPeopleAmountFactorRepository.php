<?php
declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Exception\NotFoundException;
use App\Domain\InsuredPeopleAmountFactor;
use App\Domain\Interfaces\Repository\InsuredPeopleAmountFactorRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @codeCoverageIgnore
 */
class InsuredPeopleAmountFactorRepository extends ServiceEntityRepository implements InsuredPeopleAmountFactorRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InsuredPeopleAmountFactor::class);
    }

    /**
     * @inheritDoc
     */
    public function get(int $id): InsuredPeopleAmountFactor
    {
        /** @var InsuredPeopleAmountFactor $insuredPeopleAmountFactor */
        $insuredPeopleAmountFactor = $this->find($id);

        if ($insuredPeopleAmountFactor) {
            return $insuredPeopleAmountFactor;
        }

        throw new NotFoundException(InsuredPeopleAmountFactor::class, ['id' => $id]);
    }

    /**
     * @inheritDoc
     */
    public function getByType(string $type): InsuredPeopleAmountFactor
    {
        /** @var InsuredPeopleAmountFactor $insuredPeopleAmountFactor */
        $insuredPeopleAmountFactor = $this->findOneBy(['type' => $type]);

        if ($insuredPeopleAmountFactor) {
            return $insuredPeopleAmountFactor;
        }

        throw new NotFoundException(InsuredPeopleAmountFactor::class, ['type' => $type]);
    }
}
