<?php

namespace Softify\PayumPrzelewy24Bundle\Dto;

class ErrorResponseDto implements ApiResponseInterface
{
    public string $error;
    public int $code;
    public array $data = [];

    public function getError(): string
    {
        return $this->error;
    }

    public function setError(string $error): ErrorResponseDto
    {
        $this->error = $error;
        return $this;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): ErrorResponseDto
    {
        $this->code = $code;
        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): ErrorResponseDto
    {
        $this->data = $data;
        return $this;
    }
}
