<?php

namespace Softify\PayumPrzelewy24Bundle\Dto\Refund;

class RefundRequestArrayDataBasicDto
{
    protected int $orderId;
    protected string $sessionId;
    protected int $amount;
    protected ?string $description = null;

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): RefundRequestArrayDataBasicDto
    {
        $this->orderId = $orderId;
        return $this;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function setSessionId(string $sessionId): RefundRequestArrayDataBasicDto
    {
        $this->sessionId = $sessionId;
        return $this;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): RefundRequestArrayDataBasicDto
    {
        $this->amount = $amount;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): RefundRequestArrayDataBasicDto
    {
        $this->description = $description;
        return $this;
    }
}
