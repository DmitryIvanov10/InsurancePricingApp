<?php
declare(strict_types=1);

namespace App\Services\Serializer;

use App\Domain\Exception\DomainException;
use App\Domain\ValueObject\PriceModelQuery;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * @codeCoverageIgnore
 */
class PriceModelQueryDenormalizer implements DenormalizerInterface
{
    /**
     * @throws DomainException
     */
    public function denormalize($data, $type, $format = null, array $context = [])
    {
        if (is_array($data)
            && array_key_exists('districtFactorId', $data)
            && array_key_exists('ageFactorId', $data)
            && array_key_exists('insuredPeopleAmountFactorId', $data)
            && array_key_exists('price', $data)
        ) {
            return new PriceModelQuery(
                (int)$data['districtFactorId'],
                (int)$data['ageFactorId'],
                (int)$data['insuredPeopleAmountFactorId'],
                (float)$data['price']
            );
        }

        throw new DomainException('Cannot get PriceModel data');
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === PriceModelQuery::class;
    }
}
