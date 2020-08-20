<?php
declare(strict_types=1);

namespace App\Domain;

use App\Domain\Interfaces\FactorInterface;
use JsonSerializable;

/**
 * @codeCoverageIgnore
 */
class DistrictFactor implements FactorInterface, JsonSerializable
{
    private const FACTOR_NAME = 'districtFactor';

    private int $id = 0;
    private DistrictCode $code;

    public function __construct(DistrictCode $code)
    {
        $this->code = $code;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCode(): DistrictCode
    {
        return $this->code;
    }

    /**
     * @inheritDoc
     */
    public function getFactorName(): string
    {
        return self::FACTOR_NAME;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'code' => $this->code
        ];
    }
}
