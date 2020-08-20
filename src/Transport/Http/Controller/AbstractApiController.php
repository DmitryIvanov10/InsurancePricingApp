<?php
declare(strict_types=1);

namespace App\Transport\Http\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * @codeCoverageIgnore
 */
class AbstractApiController extends AbstractController
{

    private const DENORMALIZER_FORMAT_MODELS_ARRAY = '%s[]';
    private const DENORMALIZER_FORMAT_MODEL        = '%s';

    private ?Request $request;
    private DenormalizerInterface $serializer;

    /**
     * @throws BadRequestHttpException
     */
    public function __construct(RequestStack $requestStack, DenormalizerInterface $serializer)
    {
        $this->request = $requestStack->getMasterRequest();

        if (null === $this->request) {
            throw new BadRequestHttpException('No request found');
        }
        $this->serializer = $serializer;
    }

    /**
     * @return object[]
     * @throws ExceptionInterface
     */
    protected function getArrayOfModelsFromRequestBody(string $parameterName, string $className): array
    {
        return $this->denormalizeRequestBodyParameter(
            $parameterName,
            $className,
            self::DENORMALIZER_FORMAT_MODELS_ARRAY,
            []
        );
    }

    /**
     * @throws ExceptionInterface
     */
    protected function getModelFromRequestBody(string $parameterName, string $className): object
    {
        return $this->denormalizeRequestBodyParameter($parameterName, $className, self::DENORMALIZER_FORMAT_MODEL);
    }

    /**
     * @param mixed $default
     * @return object|object[]
     * @throws ExceptionInterface
     */
    private function denormalizeRequestBodyParameter(
        string $parameterName,
        string $className,
        string $format,
        $default = null
    ) {
        return $this->serializer->denormalize(
            $this->getJsonDataFromRequest()[$parameterName] ?? $default,
            sprintf($format, $className)
        );
    }

    protected function getParameterFromRequestUrl(string $parameterName, $default = null): ?string
    {
        return $this->request->get($parameterName) ?? $default;
    }

    /**
     * @throws BadRequestHttpException
     */
    protected function getRequiredParameterFromRequestUrl(string $parameterName): string
    {
        $param = $this->getParameterFromRequestUrl($parameterName);

        if ($param) {
            return $param;
        }

        throw new BadRequestHttpException(sprintf(
            'Missing required parameter %s in the request',
            $parameterName
        ));
    }

    protected function getParameterFromRequestBody(string $parameterName, $default = 0)
    {
        return $this->getJsonDataFromRequest()[$parameterName] ?? $default;
    }

    /**
     * @throws BadRequestHttpException
     */
    protected function getRequiredParameterFromRequestBody(string $parameterName)
    {
        $param = $this->getParameterFromRequestBody($parameterName);

        if ($param) {
            return $param;
        }

        throw new BadRequestHttpException(sprintf(
            'Missing required parameter %s in the request',
            $parameterName
        ));
    }

    /**
     * @throws BadRequestHttpException
     */
    private function getJsonDataFromRequest(): array
    {
        if ($this->request->getContentType() != 'json' || !$this->request->getContent()) {
            throw new BadRequestHttpException('Incorrect request json parameters');
        }

        $data = json_decode($this->request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new BadRequestHttpException('invalid json body: ' . json_last_error_msg());
        }

        return is_array($data) ? $data : [];
    }
}
