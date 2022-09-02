<?php

namespace Softify\PayumPrzelewy24Bundle\Service;

use Softify\PayumPrzelewy24Bundle\Api\ApiInterface;
use Softify\PayumPrzelewy24Bundle\Dto\Marketplace\ApiKeyResponseDto;
use Softify\PayumPrzelewy24Bundle\Dto\ApiResponseInterface;
use Softify\PayumPrzelewy24Bundle\Dto\Marketplace\CrcResponseDto;
use Softify\PayumPrzelewy24Bundle\Dto\ErrorResponseDto;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Serializer\SerializerInterface;
use GuzzleHttp\Client;

class MarketplaceService
{
    private ClientInterface $httpClient;
    private SerializerInterface $serializer;
    private ApiInterface $api;

    public function __construct(SerializerInterface $serializer)
    {
        $this->httpClient = new Client();
        $this->serializer = $serializer;
    }

    public function setApi(ApiInterface $api): self
    {
        $this->api = $api;
        return $this;
    }

    public function getCRCKey(int $affiliateId): ApiResponseInterface
    {
        return $this->doRequest(function() use ($affiliateId) {
            return $this->httpClient->request(
                'GET',
                sprintf('%s/multiStore/%d/crc', $this->api->getMarketplaceApiUri(), $affiliateId),
                [
                    RequestOptions::AUTH => $this->getAuthData(),
                    RequestOptions::HEADERS => $this->getHeaders(),
                ]
            );
        }, CrcResponseDto::class);
    }

    public function getApiKey(int $affiliateId): ApiResponseInterface
    {
        return $this->doRequest(function() use ($affiliateId) {
            return $this->httpClient->request(
                'GET',
                sprintf('%s/multiStore/%d/apiKey', $this->api->getMarketplaceApiUri(), $affiliateId),
                [
                    RequestOptions::AUTH => $this->getAuthData(),
                    RequestOptions::HEADERS => $this->getHeaders(),
                ]
            );
        }, ApiKeyResponseDto::class);
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
            $apiResponse = $this->serializer->deserialize($body, $model, 'json');
        }
        return $apiResponse;
    }

    protected function getAuthData(): array
    {
        return [$this->api->getMarketplaceClientId(), $this->api->getMarketplaceApiKey()];
    }

    protected function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/json'
        ];
    }
}
