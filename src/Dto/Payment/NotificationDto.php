<?php

namespace Softify\PayumPrzelewy24Bundle\Dto\Payment;

class NotificationDto
{
    protected int $merchantId;
    protected int $posId;
    protected string $sessionId;
    protected int $amount;
    protected int $originAmount;
    protected string $currency = 'PLN';
    protected int $orderId;
    protected int $methodId;
    protected string $statement;
    protected string $sign;

    public function getMerchantId(): int
    {
        return $this->merchantId;
    }

    public function setMerchantId(int $merchantId): NotificationDto
    {
        $this->merchantId = $merchantId;
        return $this;
    }

    public function getPosId(): int
    {
        return $this->posId;
    }

    public function setPosId(int $posId): NotificationDto
    {
        $this->posId = $posId;
        return $this;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function setSessionId(string $sessionId): NotificationDto
    {
        $this->sessionId = $sessionId;
        return $this;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): NotificationDto
    {
        $this->amount = $amount;
        return $this;
    }

    public function getOriginAmount(): int
    {
        return $this->originAmount;
    }

    public function setOriginAmount(int $originAmount): NotificationDto
    {
        $this->originAmount = $originAmount;
        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): NotificationDto
    {
        $this->currency = $currency;
        return $this;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): NotificationDto
    {
        $this->orderId = $orderId;
        return $this;
    }

    public function getMethodId(): int
    {
        return $this->methodId;
    }

    public function setMethodId(int $methodId): NotificationDto
    {
        $this->methodId = $methodId;
        return $this;
    }

    public function getStatement(): string
    {
        return $this->statement;
    }

    public function setStatement(string $statement): NotificationDto
    {
        $this->statement = $statement;
        return $this;
    }

    public function getSign(): string
    {
        return $this->sign;
    }

    public function setSign(string $sign): NotificationDto
    {
        $this->sign = $sign;
        return $this;
    }

    public function verify(string $clientSecret): bool
    {
        return
            hash('sha384',
                json_encode([
                    'merchantId' => $this->merchantId,
                    'posId' => $this->posId,
                    'sessionId' => $this->sessionId,
                    'amount' => $this->amount,
                    'originAmount' => $this->originAmount,
                    'currency' => $this->currency,
                    'orderId' => $this->orderId,
                    'methodId' => $this->methodId,
                    'statement' => $this->statement,
                    'crc' => $clientSecret
                ],
                    JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            ) === $this->sign;
    }
}
