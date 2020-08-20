<?php
declare(strict_types=1);

namespace App\Services\DataAccess;

use App\Domain\Exception\BadArgumentException;
use App\Domain\Exception\InfrastructureExceptionInterface;
use App\Domain\Exception\NotFoundException;
use App\Domain\FactorQuery;
use App\Domain\FactorQueryDecorator;
use App\Domain\Factory\PriceModelFactory;
use App\Domain\Interfaces\FactorQueryInterface;
use App\Domain\Interfaces\Repository\AgeFactorRepositoryInterface;
use App\Domain\Interfaces\Repository\DistrictFactorRepositoryInterface;
use App\Domain\Interfaces\Repository\DistrictRepositoryInterface;
use App\Domain\Interfaces\Repository\InsuredPeopleAmountFactorRepositoryInterface;
use App\Domain\Interfaces\Repository\PriceModelRepositoryInterface;
use App\Domain\PriceModel;
use App\Domain\ValueObject\PriceModelQuery;
use App\Domain\ValueObject\PriceModelSearchQuery;

/**
 * @codeCoverageIgnore
 */
class PriceModelService implements PriceModelServiceInterface
{
    private DistrictFactorRepositoryInterface $districtFactorRepository;
    private AgeFactorRepositoryInterface $ageFactorRepository;
    private InsuredPeopleAmountFactorRepositoryInterface $insuredPeopleAmountFactorRepository;
    private PriceModelRepositoryInterface $priceModelRepository;
    private DistrictRepositoryInterface $districtRepository;
    private PriceModelFactory $priceModelFactory;

    public function __construct(
        DistrictRepositoryInterface $districtRepository,
        DistrictFactorRepositoryInterface $districtFactorRepository,
        AgeFactorRepositoryInterface $ageFactorRepository,
        InsuredPeopleAmountFactorRepositoryInterface $insuredPeopleAmountFactorRepository,
        PriceModelRepositoryInterface $priceModelRepository,
        PriceModelFactory $priceModelFactory
    ) {
        $this->districtFactorRepository = $districtFactorRepository;
        $this->ageFactorRepository = $ageFactorRepository;
        $this->insuredPeopleAmountFactorRepository = $insuredPeopleAmountFactorRepository;
        $this->priceModelRepository = $priceModelRepository;
        $this->districtRepository = $districtRepository;
        $this->priceModelFactory = $priceModelFactory;
    }

    /**
     * @inheritDoc
     */
    public function getPriceModel(PriceModelSearchQuery $priceQuery): array
    {
        $factorQuery = new FactorQuery();

        $factorQuery = $this->addDistrictFactorToQueryIfRequested($priceQuery, $factorQuery);
        $factorQuery = $this->addAgeFactorToQueryIfRequested($priceQuery, $factorQuery);
        $factorQuery = $this->addInsuredPeopleAmountFactorToQueryIfRequested($priceQuery, $factorQuery);

        return $this->priceModelRepository->findByFactors($factorQuery);
    }

    /**
     * @inheritDoc
     */
    public function createPriceModel(PriceModelQuery $priceModelQuery): PriceModel
    {
        $priceModel = $this->priceModelFactory->create(
            $priceModelQuery->getPrice(),
            $this->ageFactorRepository->get($priceModelQuery->getAgeFactorId()),
            $this->districtFactorRepository->get($priceModelQuery->getDistrictFactorId()),
            $this->insuredPeopleAmountFactorRepository->get($priceModelQuery->getInsuredPeopleAmountFactorId())
        );

        return $this->priceModelRepository->save($priceModel);
    }

    /**
     * @inheritDoc
     */
    public function updatePriceModel(int $id, float $price): PriceModel
    {
        $priceModel = $this->priceModelRepository->get($id);

        $priceModel->setPrice($price);

        return $this->priceModelRepository->save($priceModel);
    }

    /**
     * @throws InfrastructureExceptionInterface
     * @throws NotFoundException
     */
    private function addDistrictFactorToQueryIfRequested(
        PriceModelSearchQuery $priceQuery,
        FactorQueryInterface $factorQuery
    ): FactorQueryInterface {
        if (!$priceQuery->getZip()) {
            return $factorQuery;
        }

        $district = $this->districtRepository->getByZip($priceQuery->getZip());
        $districtFactor = $this->districtFactorRepository->getByCode($district->getCode());
        return new FactorQueryDecorator($factorQuery, $districtFactor);
    }

    /**
     * @throws BadArgumentException
     * @throws NotFoundException
     */
    private function addAgeFactorToQueryIfRequested(
        PriceModelSearchQuery $priceQuery,
        FactorQueryInterface $factorQuery
    ): FactorQueryInterface {
        if (!$priceQuery->getAge()) {
            return $factorQuery;
        }

        $ageFactor = $this->ageFactorRepository->getByAge($priceQuery->getAge());
        return new FactorQueryDecorator($factorQuery, $ageFactor);
    }

    /**
     * @throws BadArgumentException
     * @throws NotFoundException
     */
    private function addInsuredPeopleAmountFactorToQueryIfRequested(
        PriceModelSearchQuery $priceQuery,
        FactorQueryInterface $factorQuery
    ): FactorQueryInterface {
        if (!$priceQuery->getInsuredPeopleAmountType()) {
            return $factorQuery;
        }

        $insuredPeopleAmountFactor = $this->insuredPeopleAmountFactorRepository->getByType(
            $priceQuery->getInsuredPeopleAmountType()
        );
        return new FactorQueryDecorator($factorQuery, $insuredPeopleAmountFactor);
    }
}
