<?php

namespace Softify\PayumPrzelewy24Bundle\Dto\Marketplace;

use Softify\PayumPrzelewy24Bundle\Dto\ApiResponseInterface;

class MerchantRegisterResponseDto implements ApiResponseInterface
{
    protected ?string $error;
    protected int $code;
    protected MerchantRegisterDataObjectDto $data;

    public function getError(): ?string
    {
        return $this->error;
    }

    public function setError(?string $error): MerchantRegisterResponseDto
    {
        $this->error = $error;
        return $this;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): MerchantRegisterResponseDto
    {
        $this->code = $code;
        return $this;
    }

    public function getData(): MerchantRegisterDataObjectDto
    {
        return $this->data;
    }

    public function setData(MerchantRegisterDataObjectDto $data): MerchantRegisterResponseDto
    {
        $this->data = $data;
        return $this;
    }
}
