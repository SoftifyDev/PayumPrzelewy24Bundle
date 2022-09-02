<?php

namespace Softify\PayumPrzelewy24Bundle\Service;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use Payum\Core\Model\PaymentInterface;
use Payum\Core\Request\Capture;
use Payum\Core\Request\Notify;
use Psr\Http\Message\ResponseInterface;
use Softify\PayumPrzelewy24Bundle\Api\ApiInterface;
use Softify\PayumPrzelewy24Bundle\Dto\ErrorResponseDto;
use Softify\PayumPrzelewy24Bundle\Dto\Marketplace\ApiKeyResponseDto;
use Softify\PayumPrzelewy24Bundle\Dto\Marketplace\CrcResponseDto;
use Softify\PayumPrzelewy24Bundle\Dto\Payment\NotificationDto;
use Softify\PayumPrzelewy24Bundle\Dto\Payment\RegistrationDto;
use Softify\PayumPrzelewy24Bundle\Dto\ApiResponseInterface;
use Softify\PayumPrzelewy24Bundle\Dto\Payment\TransactionResponseDto;
use Softify\PayumPrzelewy24Bundle\Dto\Payment\VerificationDto;
use Softify\PayumPrzelewy24Bundle\Dto\Payment\VerificationResponseDto;
use Softify\PayumPrzelewy24Bundle\Exception\PaymentException;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class PaymentService
{
    private ClientInterface $httpClient;
    private SerializerInterface $serializer;
    private ApiInterface $api;
    private MarketplaceService $marketplaceService;

    public function __construct(SerializerInterface $serializer, MarketplaceService $marketplaceService)
    {
        $this->httpClient = new Client();
        $this->serializer = $serializer;
        $this->marketplaceService = $marketplaceService;
    }

    public function getMarketplaceService(): MarketplaceService
    {
        return $this->marketplaceService;
    }

    public function setApi(ApiInterface $api): self
    {
        $this->api = $api;
        $this->marketplaceService->setApi($api);
        return $this;
    }

    public function registerTransaction(Capture $request, string $urlStatus): ApiResponseInterface
    {
        $this->preRequest();
        $dto = $this->createRegistrationDto($request, $urlStatus);
        return $this->doRequest(function() use ($dto) {
            return $this->httpClient->request(
                'POST', sprintf('%s/%s', $this->api->getApiUrl(), ApiInterface::URI_TRANSACTION_REGISTER),
                [
                    RequestOptions::BODY => $this->serializer->serialize($dto, 'json'),
                    RequestOptions::AUTH => $this->api->getAuthData(),
                    RequestOptions::HEADERS => $this->getHeaders(),
                ]
            );
        }, TransactionResponseDto::class);
    }

    public function verifyTransaction(Notify $request, NotificationDto $notificationDto): ApiResponseInterface
    {
        $this->preRequest();
        $dto = $this->createVerificationDto($notificationDto);
        return $this->doRequest(function() use ($dto) {
            return $this->httpClient->request(
                'PUT', sprintf('%s/%s', $this->api->getApiUrl(), ApiInterface::URI_TRANSACTION_VERIFY),
                [
                    RequestOptions::BODY => $this->serializer->serialize($dto, 'json'),
                    RequestOptions::AUTH => $this->api->getAuthData(),
                    RequestOptions::HEADERS => $this->getHeaders(),
                ]
            );
        }, VerificationResponseDto::class);
    }

    public function deserializeNotification(string $payload): NotificationDto
    {
        return $this->serializer->deserialize($payload, NotificationDto::class, 'json');
    }

    protected function doRequest(callable $callback, string $model): ApiResponseInterface
    {
        try {
            /** @var ResponseInterface $response */
            $response = $callback();
        } catch (RequestException $exception) {
            $response = $exception->getResponse();
            $model = ErrorResponseDto::class;
        } finally {
            $body = $response->getBody()->getContents();
            /** @var TransactionResponseDto $apiResponse */
            $apiResponse = $this->deserialize($body, $model);
        }
        return $apiResponse;
    }

    protected function createRegistrationDto(Capture $request, string $urlStatus): RegistrationDto
    {
        /** @var PaymentInterface $payment */
        $payment = $request->getFirstModel();

        $dto = new RegistrationDto();
        $dto
            ->setMerchantId($this->api->getClientId())
            ->setPosId($this->api->getClientId())
            ->setSessionId($payment->getNumber())
            ->setAmount($payment->getTotalAmount())
            ->setDescription($payment->getDescription())
            ->setEmail($payment->getClientEmail())
            ->setUrlReturn(sprintf(
                '%s?%s',
                $request->getToken()->getTargetUrl(),
                http_build_query(['status' => ApiInterface::PENDING_STATUS])
            ))
            ->setUrlCancel(sprintf(
                '%s?%s',
                $request->getToken()->getTargetUrl(),
                http_build_query(['status' => ApiInterface::CANCELLED_STATUS])
            ))
            ->setUrlStatus($urlStatus)
            ->countSignAndSet($this->api->getClientSecret());

        if (isset($payment->getDetails()['timeLimit'])) {
            $dto->setTimeLimit(
                $payment->getDetails()['timeLimit'] > 99 ? 99 : $payment->getDetails()['timeLimit']
            );
        }

        return $dto;
    }

    protected function createVerificationDto(NotificationDto $notificationDto): VerificationDto
    {
        $verification = new VerificationDto();
        $verification
            ->setMerchantId($notificationDto->getMethodId())
            ->setPosId($notificationDto->getPosId())
            ->setSessionId($notificationDto->getSessionId())
            ->setAmount($notificationDto->getAmount())
            ->setCurrency($notificationDto->getCurrency())
            ->setOrderId($notificationDto->getOrderId())
            ->countSignAndSet($this->api->getClientSecret());

        return $verification;
    }

    protected function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/json'
        ];
    }

    protected function deserialize(string $content, string $model): ApiResponseInterface
    {
        return $this->serializer->deserialize(
            $content,
            $model,
            'json',
            [
                DateTimeNormalizer::FORMAT_KEY => 'U'
            ]
        );
    }

    protected function preRequest(): void
    {
        if ($this->api->isMarketplace()) {
            /** @var CrcResponseDto $response */
            $response = $this->marketplaceService->getCRCKey($this->api->getClientId());
            if ($response instanceof ErrorResponseDto) {
                throw PaymentException::newInstanceFromErrorResponse($response);
            }
            $this->api->setClientSecret($response->getData()->getCrc());

            /** @var ApiKeyResponseDto $response */
            $response = $this->marketplaceService->getApiKey($this->api->getClientId());
            if ($response instanceof ErrorResponseDto) {
                throw PaymentException::newInstanceFromErrorResponse($response);
            }
            $this->api->setApiKey($response->getApiKey());
        }
    }
}
