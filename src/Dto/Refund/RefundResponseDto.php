<?php

namespace Softify\PayumPrzelewy24Bundle\Dto\Refund;

use Softify\PayumPrzelewy24Bundle\Dto\ApiResponseInterface;

class RefundResponseDto implements ApiResponseInterface
{
    /**
     * @var TransactionRefundItemDto[]
     */
    protected array $data;
    protected int $responseCode;

    /**
     * @return TransactionRefundItemDto[]
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param TransactionRefundItemDto[] $data
     */
    public function setData(array $data): RefundResponseDto
    {
        $this->data = $data;
        return $this;
    }

    public function getResponseCode(): int
    {
        return $this->responseCode;
    }

    public function setResponseCode(int $responseCode): RefundResponseDto
    {
        $this->responseCode = $responseCode;
        return $this;
    }
}
