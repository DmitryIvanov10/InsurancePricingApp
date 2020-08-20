<?php
declare(strict_types=1);

namespace App\Domain;

use App\Domain\Exception\BadArgumentException;
use App\Domain\Interfaces\FactorInterface;
use JsonSerializable;

/**
 * TODO cover with unit test
 */
class AgeFactor implements FactorInterface, JsonSerializable
{
    private const FACTOR_NAME = 'ageFactor';

    private const TYPE_OLD   = 'OLD';
    private const TYPE_YOUNG = 'YOUNG';

    private const TYPES = [
        self::TYPE_YOUNG,
        self::TYPE_OLD
    ];

    private const AGE_MAX   = 99;
    private const AGE_OLD   = 45;
    private const AGE_YOUNG = 18;

    private int $id = 0;
    private string $type;

    /**
     * @throws BadArgumentException
     */
    final public static function getTypeByAge(int $age): string
    {
        switch (true) {
            case $age > self::AGE_MAX:
                throw new BadArgumentException(sprintf('Maximum age value is %s', self::AGE_MAX));
            case $age >= self::AGE_OLD:
                return self::TYPE_OLD;
            case $age >= self::AGE_YOUNG:
                return self::TYPE_YOUNG;
            default:
                throw new BadArgumentException(sprintf('Minimum age value is %s', self::AGE_YOUNG));
        }
    }

    /**
     * @throws BadArgumentException
     */
    public function __construct(string $type)
    {
        $this->validateType($type);

        $this->type = $type;
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
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @inheritDoc
     * @codeCoverageIgnore
     */
    public function getFactorName(): string
    {
        return self::FACTOR_NAME;
    }

    /**
     * @inheritDoc
     * @codeCoverageIgnore
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'type' => $this->type
        ];
    }

    /**
     * @throws BadArgumentException
     */
    private function validateType(string $type): void
    {
        if (!in_array($type, self::TYPES)) {
            throw new BadArgumentException(sprintf('Invalid type: %s', $type));
        }
    }
}
