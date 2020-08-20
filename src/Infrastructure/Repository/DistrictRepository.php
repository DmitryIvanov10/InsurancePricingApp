<?php
declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\District;
use App\Domain\Exception\NotFoundException;
use App\Domain\Interfaces\Repository\DistrictRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @codeCoverageIgnore
 */
class DistrictRepository extends ServiceEntityRepository implements DistrictRepositoryInterface
{
    private DistrictRepositoryInterface $externalDistrictRepository;

    public function __construct(ManagerRegistry $registry, DistrictRepositoryInterface $externalDistrictRepository)
    {
        parent::__construct($registry, District::class);
        $this->externalDistrictRepository = $externalDistrictRepository;
    }

    /**
     * @inheritDoc
     */
    public function getByZip(int $zip): District
    {
        /** @var District $district */
        $district = $this->findOneBy(['zip' => $zip]);

        return $district ?? $this->getFromExternalSourceAndUpdate($zip);
    }

    /**
     * @throws NotFoundException
     */
    private function getFromExternalSourceAndUpdate(int $zip): District
    {
        $district = $this->externalDistrictRepository->getByZip($zip);

        $em = $this->getEntityManager();

        try {
            $em->persist($district->getCode());
            $em->persist($district);
            $em->flush();
        } catch (ORMException $exception) {
            // Do nothing
        }

        return $district;
    }
}
