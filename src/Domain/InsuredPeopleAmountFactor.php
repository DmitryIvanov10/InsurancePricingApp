<?php
declare(strict_types=1);

namespace App\Domain;

use App\Domain\Exception\BadArgumentException;
use App\Domain\Interfaces\FactorInterface;
use JsonSerializable;

/**
 * TODO cover with unit test
 */
class InsuredPeopleAmountFactor implements FactorInterface, JsonSerializable
{
    private const FACTOR_NAME = 'insuredPeopleAmountFactor';

    private const TYPE_ALONE = 'ALONE';
    private const TYPE_GROUP = 'GROUP';

    private const TYPES = [
        self::TYPE_ALONE,
        self::TYPE_GROUP
    ];

    private int $id = 0;
    private string $type;

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
