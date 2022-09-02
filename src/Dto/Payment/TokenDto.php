<?php

namespace Softify\PayumPrzelewy24Bundle\Dto\Payment;

class TokenDto
{
    protected string $token;

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): TokenDto
    {
        $this->token = $token;
        return $this;
    }
}
