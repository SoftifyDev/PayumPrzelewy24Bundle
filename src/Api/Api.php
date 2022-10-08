<?php

namespace Softify\PayumPrzelewy24Bundle\Api;

class Api implements ApiInterface
{
    private ?int $clientId;
    private ?string $clientSecret;
    private ?string $apiKey;
    private bool $sandbox;
    private bool $marketplace;
    private ?string $marketplaceApiKey;
    private ?int $marketplaceClientId;
    private ?string $marketplaceApiUri;
    private array $actions;

    /**
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->clientId = $parameters['clientId'];
        $this->clientSecret = $parameters['clientSecret'];
        $this->apiKey = $parameters['apiKey'];
        $this->sandbox = (bool)$parameters['sandbox'];
        $this->marketplace = (bool)$parameters['marketplace'];
        $this->marketplaceApiKey = $parameters['marketplaceApiKey'];
        $this->marketplaceClientId = $parameters['marketplaceClientId'];
        $this->marketplaceApiUri = $parameters['marketplaceApiUri'];
        $this->actions = $parameters['actions'] ?? [];
    }

    public function getClientId(): ?int
    {
        return $this->clientId;
    }

    public function setClientId(?int $clientId): void
    {
        $this->clientId = $clientId;
    }

    public function getClientSecret(): ?string
    {
        return $this->clientSecret;
    }

    public function setClientSecret(?string $clientSecret): void
    {
        $this->clientSecret = $clientSecret;
    }

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    public function setApiKey(?string $apiKey): void
    {
        $this->apiKey = $apiKey;
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

    public function isMarketplace(): bool
    {
        return $this->marketplace;
    }

    public function getMarketplaceApiKey(): ?string
    {
        return $this->marketplaceApiKey;
    }

    public function getMarketplaceClientId(): ?int
    {
        return $this->marketplaceClientId;
    }

    public function getMarketplaceApiUri(): ?string
    {
        if ($this->marketplace) {
            return $this->marketplaceApiUri ?? self::API_URL_PRODUCTION;
        }
        return null;
    }

    public function invalidateCaptureToken(): bool
    {
        return $this->actions['invalidateCaptureToken'] ?? true;
    }
}
