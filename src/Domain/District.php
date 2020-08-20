<?php
declare(strict_types=1);

namespace App\Domain;

use App\Domain\Exception\BadArgumentException;
use JsonSerializable;

/**
 * TODO cover with unit test
 */
class District implements JsonSerializable
{
    private const ZIP_LENGTH = 4;

    private int $id = 0;
    private int $zip;
    private string $city;
    private DistrictCode $code;

    /**
     * @throws BadArgumentException
     */
    public function __construct(int $zip, string $city, DistrictCode $code)
    {
        $this->validateZip($zip);

        $this->zip = $zip;
        $this->code = $code;
        $this->city = $city;
    }

    /**
     * @inheritDoc
     * @codeCoverageIgnore
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getZip(): int
    {
        return $this->zip;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getCode(): DistrictCode
    {
        return $this->code;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @inheritDoc
     * @codeCoverageIgnore
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'zip' => $this->zip,
            'city' => $this->city,
            'code' => $this->code
        ];
    }

    /**
     * @throws BadArgumentException
     */
    private function validateZip(int $zip)
    {
        if (self::ZIP_LENGTH !== strlen((string)$zip)) {
            throw new BadArgumentException(sprintf('Zip length has to be %s', self::ZIP_LENGTH));
        }
    }
}
