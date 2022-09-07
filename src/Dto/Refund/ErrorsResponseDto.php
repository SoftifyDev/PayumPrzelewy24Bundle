<?php

namespace Softify\PayumPrzelewy24Bundle\Dto\Refund;

use Softify\PayumPrzelewy24Bundle\Dto\ApiResponseInterface;
use Softify\PayumPrzelewy24Bundle\Dto\ErrorResponseInterface;

class ErrorsResponseDto implements ApiResponseInterface, ErrorResponseInterface
{
    /**
     * @var TransactionRefundItemDto[]
     */
    public array $error = [];
    public int $code;

    /**
     * @return TransactionRefundItemDto[]
     */
    public function getError(): array
    {
        return $this->error;
    }

    /**
     * @param TransactionRefundItemDto[] $error
     */
    public function setError(array $error): ErrorsResponseDto
    {
        $this->error = $error;
        return $this;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): ErrorsResponseDto
    {
        $this->code = $code;
        return $this;
    }
}
