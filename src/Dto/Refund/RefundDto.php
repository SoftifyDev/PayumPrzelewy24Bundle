<?php

namespace Softify\PayumPrzelewy24Bundle\Dto\Refund;

class RefundDto
{
    protected string $requestId;
    protected string $refundsUuid;
    protected ?string $urlStatus = null;

    /**
     * @var RefundRequestArrayDataBasicDto[]
     */
    protected array $refunds;

    public function getRequestId(): string
    {
        return $this->requestId;
    }

    public function setRequestId(string $requestId): RefundDto
    {
        $this->requestId = $requestId;
        return $this;
    }

    public function getRefundsUuid(): string
    {
        return $this->refundsUuid;
    }

    public function setRefundsUuid(string $refundsUuid): RefundDto
    {
        $this->refundsUuid = $refundsUuid;
        return $this;
    }

    public function getUrlStatus(): ?string
    {
        return $this->urlStatus;
    }

    public function setUrlStatus(?string $urlStatus): RefundDto
    {
        $this->urlStatus = $urlStatus;
        return $this;
    }

    /**
     * @return RefundRequestArrayDataBasicDto[]
     */
    public function getRefunds(): array
    {
        return $this->refunds;
    }

    /**
     * @param RefundRequestArrayDataBasicDto[] $refunds
     */
    public function setRefunds(array $refunds): RefundDto
    {
        $this->refunds = $refunds;
        return $this;
    }
}
