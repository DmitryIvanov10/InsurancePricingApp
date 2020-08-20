<?php
declare(strict_types=1);

namespace App\Domain;

use App\Domain\Exception\BadArgumentException;
use JsonSerializable;

/**
 * TODO cover with unit test
 */
class DistrictCode implements JsonSerializable
{
    private const VALUE_LENGTH = 2;

    private int $id = 0;
    private string $value;

    /**
     * @throws BadArgumentException
     */
    public function __construct(string $value)
    {
        $this->validateValue($value);

        $this->value = $value;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     * @codeCoverageIgnore
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'value' => $this->value
        ];
    }

    /**
     * @throws BadArgumentException
     */
    private function validateValue(string $value)
    {
        if (self::VALUE_LENGTH !== strlen($value)) {
            throw new BadArgumentException(sprintf('Code value length has to be %s', self::VALUE_LENGTH));
        }
    }
}
