<?php

namespace Softify\PayumPrzelewy24Bundle\Dto;

class ErrorResponseDto implements ResponseDtoInterface
{
    protected string $error;
    protected int $code;

    public function getError(): string
    {
        return $this->error;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function setError(string $error): ErrorResponseDto
    {
        $this->error = $error;
        return $this;
    }

    public function setCode(int $code): ErrorResponseDto
    {
        $this->code = $code;
        return $this;
    }
}
