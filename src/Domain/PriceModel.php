<?php
declare(strict_types=1);

namespace App\Domain;

use JsonSerializable;

/**
 * @codeCoverageIgnore
 */
class PriceModel implements JsonSerializable
{
    private int $id = 0;
    private float $price;
    private AgeFactor $ageFactor;
    private DistrictFactor $districtFactor;
    private InsuredPeopleAmountFactor $insuredPeopleAmountFactor;

    public function __construct(
        float $price,
        AgeFactor $ageFactor,
        DistrictFactor $districtFactor,
        InsuredPeopleAmountFactor $insuredPeopleAmountFactor
    ) {
        $this->price = $price;
        $this->ageFactor = $ageFactor;
        $this->districtFactor = $districtFactor;
        $this->insuredPeopleAmountFactor = $insuredPeopleAmountFactor;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getAgeFactor(): AgeFactor
    {
        return $this->ageFactor;
    }

    public function getDistrictFactor(): DistrictFactor
    {
        return $this->districtFactor;
    }

    public function getInsuredPeopleAmountFactor(): InsuredPeopleAmountFactor
    {
        return $this->insuredPeopleAmountFactor;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'ageFactor' => $this->ageFactor,
            'districtFactor' => $this->districtFactor,
            'insuredPeopleAmountFactor' => $this->insuredPeopleAmountFactor
        ];
    }
}
