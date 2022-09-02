<?php

namespace Softify\PayumPrzelewy24Bundle\Dto\Payment;

use Softify\PayumPrzelewy24Bundle\Dto\ApiResponseInterface;

class TransactionResponseDto extends AbstractResponseDto implements ApiResponseInterface
{
    protected TokenDto $data;

    public function getData(): TokenDto
    {
        return $this->data;
    }

    public function setData(TokenDto $data): TransactionResponseDto
    {
        $this->data = $data;
        return $this;
    }
}
