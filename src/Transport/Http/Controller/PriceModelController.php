<?php
declare(strict_types=1);

namespace App\Transport\Http\Controller;

use App\Domain\Exception\BadArgumentException;
use App\Domain\Exception\InfrastructureExceptionInterface;
use App\Domain\Exception\NotFoundException;
use App\Domain\ValueObject\PriceModelQuery;
use App\Domain\ValueObject\PriceModelSearchQuery;
use App\Services\DataAccess\PriceModelServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use TypeError;

/**
 * @codeCoverageIgnore
 */
class PriceModelController extends AbstractApiController
{
    /**
     * @throws NotFoundException
     * @throws BadArgumentException
     * @throws InfrastructureExceptionInterface
     */
    public function getPriceModel(PriceModelServiceInterface $priceModelService): JsonResponse
    {
        $zip = $this->getParameterFromRequestUrl('zip');
        $age = $this->getParameterFromRequestUrl('age');

        $priceQuery = new PriceModelSearchQuery(
            $zip ? (int)$zip : null,
            $age ? (int)$age : null,
            $this->getParameterFromRequestUrl('insuredPeopleAmountType')
        );

        return $this->json(
            $priceModelService->getPriceModel($priceQuery)
        );
    }

    /**
     * @throws NotFoundException
     * @throws InfrastructureExceptionInterface
     */
    public function createPriceModel(PriceModelServiceInterface $priceModelService): JsonResponse
    {
        try {
            /** @var PriceModelQuery $priceModelQuery */
            $priceModelQuery = $this->getModelFromRequestBody('priceModel', PriceModelQuery::class);
        } catch (ExceptionInterface|TypeError $exception) {
            throw new BadRequestHttpException(
                'Wrong PriceModel query parameters',
                $exception
            );
        }

        return $this->json(
            $priceModelService->createPriceModel($priceModelQuery)
        );
    }

    /**
     * @throws InfrastructureExceptionInterface
     * @throws NotFoundException
     */
    public function updatePriceModel(int $id, PriceModelServiceInterface $priceModelService): JsonResponse
    {
        $price = $this->getRequiredParameterFromRequestBody('price');

        return $this->json(
            $priceModelService->updatePriceModel($id, $price)
        );
    }
}
