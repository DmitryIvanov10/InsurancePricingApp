<?php
declare(strict_types=1);

namespace App\Domain\ValueObject;

/**
 * @codeCoverageIgnore
 */
class PriceModelQuery
{
    private int $districtFactorId;
    private int $ageFactorId;
    private int $insuredPeopleAmountFactorId;
    private float $price;

    public function __construct(
        int $districtFactorId,
        int $ageFactorId,
        int $insuredPeopleAmountFactorId,
        float $price
    ) {
        $this->districtFactorId = $districtFactorId;
        $this->ageFactorId = $ageFactorId;
        $this->insuredPeopleAmountFactorId = $insuredPeopleAmountFactorId;
        $this->price = $price;
    }

    public function getDistrictFactorId(): int
    {
        return $this->districtFactorId;
    }

    public function getAgeFactorId(): int
    {
        return $this->ageFactorId;
    }

    public function getInsuredPeopleAmountFactorId(): int
    {
        return $this->insuredPeopleAmountFactorId;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
