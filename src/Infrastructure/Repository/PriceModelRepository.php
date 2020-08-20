<?php
declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Exception\NotFoundException;
use App\Domain\Interfaces\FactorQueryInterface;
use App\Domain\Interfaces\Repository\PriceModelRepositoryInterface;
use App\Domain\PriceModel;
use App\Infrastructure\Exception\InfrastructureException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @codeCoverageIgnore
 */
class PriceModelRepository extends ServiceEntityRepository implements PriceModelRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PriceModel::class);
    }

    /**
     * @inheritDoc
     */
    public function save(PriceModel $priceModel): PriceModel
    {
        $em = $this->getEntityManager();

        try {
            $em->persist($priceModel);
            $em->flush();
        } catch (ORMException $exception) {
            throw new InfrastructureException('Couldn\'t save PriceModel to the DB', 0, $exception);
        } catch (UniqueConstraintViolationException $exception) {
            throw new InfrastructureException('Price model for such factors already exists', 0, $exception);
        }

        return $priceModel;
    }

    /**
     * @inheritDoc
     */
    public function get(int $id): PriceModel
    {
        /** @var PriceModel $priceModel */
        $priceModel = $this->find($id);

        if ($priceModel) {
            return $priceModel;
        }

        throw new NotFoundException(PriceModel::class, ['id' => $id]);
    }

    /**
     * @inheritDoc
     */
    public function findByFactors(FactorQueryInterface $factorQuery): array
    {
        return $this->findBy($factorQuery->getFactors());
    }
}
