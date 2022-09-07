<?php

namespace Softify\PayumPrzelewy24Bundle\Dto\Refund;

class NotificationDto
{
    protected int $orderId;
    protected string $sessionId;
    protected int $merchantId;
    protected string $requestId;
    protected string $refundsUuid;
    protected int $amount;
    protected string $currency;
    protected int $timestamp;
    protected int $status;
    protected string $sign;

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): NotificationDto
    {
        $this->orderId = $orderId;
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

    public function getMerchantId(): int
    {
        return $this->merchantId;
    }

    public function setMerchantId(int $merchantId): NotificationDto
    {
        $this->merchantId = $merchantId;
        return $this;
    }

    public function getRequestId(): string
    {
        return $this->requestId;
    }

    public function setRequestId(string $requestId): NotificationDto
    {
        $this->requestId = $requestId;
        return $this;
    }

    public function getRefundsUuid(): string
    {
        return $this->refundsUuid;
    }

    public function setRefundsUuid(string $refundsUuid): NotificationDto
    {
        $this->refundsUuid = $refundsUuid;
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

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): NotificationDto
    {
        $this->currency = $currency;
        return $this;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function setTimestamp(int $timestamp): NotificationDto
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): NotificationDto
    {
        $this->status = $status;
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
                    'orderId' => $this->orderId,
                    'sessionId' => $this->sessionId,
                    'refundsUuid' => $this->refundsUuid,
                    'merchantId' => $this->merchantId,
                    'amount' => $this->amount,
                    'currency' => $this->currency,
                    'status' => $this->status,
                    'crc' => $clientSecret
                ],
                    JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            ) === $this->sign;
    }
}
