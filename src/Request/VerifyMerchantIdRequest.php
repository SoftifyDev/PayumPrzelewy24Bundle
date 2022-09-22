<?php

namespace Softify\PayumPrzelewy24Bundle\Request;

use Softify\PayumPrzelewy24Bundle\Dto\ApiResponseInterface;

class VerifyMerchantIdRequest
{
    protected int $merchantId;
    protected string $nip;
    protected ?string $regon;

    protected ApiResponseInterface $affiliatesResponseDto;

    public function __construct(int $merchantId, string $nip, string $regon = null)
    {
        $this->merchantId = $merchantId;
        $this->nip = $nip;
        $this->regon = $regon;
    }

    public function getMerchantId(): int
    {
        return $this->merchantId;
    }

    public function getNip(): string
    {
        return $this->nip;
    }

    public function getRegon(): ?string
    {
        return $this->regon;
    }

    public function getAffiliatesResponseDto(): ApiResponseInterface
    {
        return $this->affiliatesResponseDto;
    }

    public function setAffiliatesResponseDto(ApiResponseInterface $affiliatesResponseDto): self
    {
        $this->affiliatesResponseDto = $affiliatesResponseDto;
        return $this;
    }
}
