<?php

namespace Softify\PayumPrzelewy24Bundle\Api;

class Api implements ApiInterface
{
    private int $clientId;
    private string $clientSecret;
    private string $apiKey;
    private bool $sandbox;

    /**
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->clientId = (int)$parameters['clientId'];
        $this->clientSecret = $parameters['clientSecret'];
        $this->apiKey = $parameters['apiKey'];
        $this->sandbox = (bool)$parameters['sandbox'];
    }

    public function getClientId(): int
    {
        return $this->clientId;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getUrl(): string
    {
        return $this->sandbox ? self::URL_SANDBOX : self::URL_PRODUCTION;
    }

    public function getApiUrl(): string
    {
        return $this->sandbox ? self::API_URL_SANDBOX : self::API_URL_PRODUCTION;
    }

    public function getAuthData(): array
    {
        return [$this->clientId, $this->apiKey];
    }
}
