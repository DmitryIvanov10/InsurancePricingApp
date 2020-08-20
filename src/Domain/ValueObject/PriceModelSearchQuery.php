<?php
declare(strict_types=1);

namespace App\Domain\ValueObject;

/**
 * @codeCoverageIgnore
 */
class PriceModelSearchQuery
{
    private ?int $zip;
    private ?int $age;
    private ?string $insuredPeopleAmountType;

    public function __construct(?int $zip, ?int $age, ?string $insuredPeopleAmountType)
    {
        $this->zip = $zip;
        $this->age = $age;
        $this->insuredPeopleAmountType = $insuredPeopleAmountType;
    }

    public function getZip(): ?int
    {
        return $this->zip;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function getInsuredPeopleAmountType(): ?string
    {
        return $this->insuredPeopleAmountType;
    }
}
