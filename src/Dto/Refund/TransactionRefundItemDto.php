<?php

namespace Softify\PayumPrzelewy24Bundle\Dto\Refund;

class TransactionRefundItemDto
{
    protected int $orderId;
    protected string $sessionId;
    protected int $amount;
    protected ?string $description = null;
    protected bool $status;
    protected string $message;

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): TransactionRefundItemDto
    {
        $this->orderId = $orderId;
        return $this;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function setSessionId(string $sessionId): TransactionRefundItemDto
    {
        $this->sessionId = $sessionId;
        return $this;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): TransactionRefundItemDto
    {
        $this->amount = $amount;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): TransactionRefundItemDto
    {
        $this->description = $description;
        return $this;
    }

    public function isStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): TransactionRefundItemDto
    {
        $this->status = $status;
        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): TransactionRefundItemDto
    {
        $this->message = $message;
        return $this;
    }
}
