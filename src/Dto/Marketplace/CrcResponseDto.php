<?php

namespace Softify\PayumPrzelewy24Bundle\Dto\Marketplace;

use Softify\PayumPrzelewy24Bundle\Dto\ApiResponseInterface;

class CrcResponseDto implements ApiResponseInterface
{
    protected CrcDataObjectDto $data;
    protected string $error;

    public function getData(): CrcDataObjectDto
    {
        return $this->data;
    }

    public function setData(CrcDataObjectDto $data): CrcResponseDto
    {
        $this->data = $data;
        return $this;
    }

    public function getError(): string
    {
        return $this->error;
    }

    public function setError(string $error): CrcResponseDto
    {
        $this->error = $error;
        return $this;
    }
}
