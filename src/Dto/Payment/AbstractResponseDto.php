<?php

namespace Softify\PayumPrzelewy24Bundle\Dto\Payment;

abstract class AbstractResponseDto
{
    protected int $responseCode;

    public function getResponseCode(): int
    {
        return $this->responseCode;
    }

    public function setResponseCode(int $responseCode): AbstractResponseDto
    {
        $this->responseCode = $responseCode;
        return $this;
    }
}
