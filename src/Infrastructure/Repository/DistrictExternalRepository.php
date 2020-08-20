<?php
declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\District;
use App\Domain\Exception\BadArgumentException;
use App\Domain\Exception\NotFoundException;
use App\Domain\Factory\DistrictCodeFactory;
use App\Domain\Factory\DistrictFactory;
use App\Domain\Interfaces\Repository\DistrictCodeRepositoryInterface;
use App\Domain\Interfaces\Repository\DistrictRepositoryInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @codeCoverageIgnore
 */
class DistrictExternalRepository implements DistrictRepositoryInterface
{
    private const URL = 'https://swisspost.opendatasoft.com/api/records/1.0/search/?dataset=plz_verzeichnis_v2&refine.postleitzahl=%s';

    private const FIELD_NAME_ZIP  = 'postleitzahl';
    private const FIELD_NAME_CODE = 'kanton';
    private const FIELD_NAME_CITY = 'ortbez18';

    private HttpClientInterface $httpClient;
    private DistrictFactory $districtFactory;
    private DistrictCodeFactory $districtCodeFactory;
    private DistrictCodeRepositoryInterface $districtCodeRepository;

    public function __construct(
        HttpClientInterface $httpClient,
        DistrictFactory $districtFactory,
        DistrictCodeFactory $districtCodeFactory,
        DistrictCodeRepositoryInterface $districtCodeRepository
    ) {
        $this->httpClient = $httpClient;
        $this->districtFactory = $districtFactory;
        $this->districtCodeFactory = $districtCodeFactory;
        $this->districtCodeRepository = $districtCodeRepository;
    }

    /**
     * @inheritDoc
     */
    public function getByZip(int $zip): District
    {
        try {
            $response = $this->httpClient->request('GET', sprintf(self::URL, $zip));
            $responseContent = json_decode($response->getContent(), true);
        } catch (
            TransportExceptionInterface
            |ServerExceptionInterface
            |RedirectionExceptionInterface
            |ClientExceptionInterface $exception
        ) {
            throw new NotFoundException(District::class, ['zip' => $zip], $exception);
        }

        $districtData = $responseContent['records'][0]['fields'] ?? null;

        if (!$districtData) {
            throw new NotFoundException(District::class, ['zip' => $zip]);
        }

        try {
            $districtCode = $this->districtCodeRepository->findByCodeValue($districtData[self::FIELD_NAME_CODE])
                ?? $this->districtCodeFactory->create($districtData[self::FIELD_NAME_CODE]);

            $district = $this->districtFactory->create(
                $districtData[self::FIELD_NAME_ZIP],
                $districtData[self::FIELD_NAME_CITY],
                $districtCode
            );
        } catch (BadArgumentException $exception) {
            throw new NotFoundException(District::class, ['zip' => $zip], $exception);
        }

        return $district;
    }
}
