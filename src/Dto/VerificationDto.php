<?php

namespace Softify\PayumPrzelewy24Bundle\Dto;

class VerificationDto
{
    protected int $merchantId;
    protected int $posId;
    protected string $sessionId;
    protected int $amount;
    protected string $currency = 'PLN';
    protected int $orderId;
    protected string $sign;

    public function getMerchantId(): int
    {
        return $this->merchantId;
    }

    public function setMerchantId(int $merchantId): VerificationDto
    {
        $this->merchantId = $merchantId;
        return $this;
    }

    public function getPosId(): int
    {
        return $this->posId;
    }

    public function setPosId(int $posId): VerificationDto
    {
        $this->posId = $posId;
        return $this;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function setSessionId(string $sessionId): VerificationDto
    {
        $this->sessionId = $sessionId;
        return $this;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): VerificationDto
    {
        $this->amount = $amount;
        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): VerificationDto
    {
        $this->currency = $currency;
        return $this;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): VerificationDto
    {
        $this->orderId = $orderId;
        return $this;
    }

    public function getSign(): string
    {
        return $this->sign;
    }

    public function setSign(string $sign): VerificationDto
    {
        $this->sign = $sign;
        return $this;
    }

    public function countSignAndSet(string $clientSecret): VerificationDto
    {
        $data = [
            'sessionId' => $this->sessionId,
            'orderId' => $this->orderId,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'crc' => $clientSecret,
        ];

        $this->sign = hash('sha384', json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        return $this;
    }

}
