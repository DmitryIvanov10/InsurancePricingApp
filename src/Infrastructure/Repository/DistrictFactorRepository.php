<?php
declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\DistrictCode;
use App\Domain\DistrictFactor;
use App\Domain\Exception\NotFoundException;
use App\Domain\Interfaces\Repository\DistrictFactorRepositoryInterface;
use App\Infrastructure\Exception\InfrastructureException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @codeCoverageIgnore
 */
class DistrictFactorRepository extends ServiceEntityRepository implements DistrictFactorRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DistrictFactor::class);
    }

    /**
     * @inheritDoc
     */
    public function get(int $id): DistrictFactor
    {
        /** @var DistrictFactor $districtFactor */
        $districtFactor = $this->find($id);

        if ($districtFactor) {
            return $districtFactor;
        }

        throw new NotFoundException(DistrictFactor::class, ['id' => $id]);
    }

    /**
     * @inheritDoc
     */
    public function getByCode(DistrictCode $code): DistrictFactor
    {
        $qb = $this->createQueryBuilder('df');

        $qb
            ->andWhere('df.code = :code')
            ->setParameter('code', $code);

        try {
            return $qb
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $exception) {
            throw new NotFoundException(DistrictFactor::class, ['code' => $code->getValue()], $exception);
        } catch (NonUniqueResultException $exception) {
            throw new InfrastructureException(sprintf(
                'Non-unique district factor for the code: %s',
                $code->getValue()
            ), 0, $exception);
        }
    }
}
