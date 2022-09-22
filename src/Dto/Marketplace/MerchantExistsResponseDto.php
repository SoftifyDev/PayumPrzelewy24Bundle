<?php

namespace Softify\PayumPrzelewy24Bundle\Dto\Marketplace;

use Softify\PayumPrzelewy24Bundle\Dto\ApiResponseInterface;

class MerchantExistsResponseDto implements ApiResponseInterface
{
    /**
     * @var string[]
     */
    protected array $data;
    protected string $error;

    /**
     * @return string[]
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param string[] $data
     */
    public function setData(array $data): MerchantExistsResponseDto
    {
        $this->data = $data;
        return $this;
    }

    public function getError(): string
    {
        return $this->error;
    }

    public function setError(string $error): MerchantExistsResponseDto
    {
        $this->error = $error;
        return $this;
    }
}
