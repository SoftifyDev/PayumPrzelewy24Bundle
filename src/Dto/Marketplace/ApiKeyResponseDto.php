<?php

namespace Softify\PayumPrzelewy24Bundle\Dto\Marketplace;

use Softify\PayumPrzelewy24Bundle\Dto\ApiResponseInterface;

class ApiKeyResponseDto implements ApiResponseInterface
{
    protected string $apiKey;
    protected string $type;
    protected string $name;

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function setApiKey(string $apiKey): ApiKeyResponseDto
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): ApiKeyResponseDto
    {
        $this->type = $type;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): ApiKeyResponseDto
    {
        $this->name = $name;
        return $this;
    }
}
