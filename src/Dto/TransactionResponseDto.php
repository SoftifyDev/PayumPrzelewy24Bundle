<?php

namespace Softify\PayumPrzelewy24Bundle\Dto;

class TransactionResponseDto extends AbstractResponseDto implements ResponseDtoInterface
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
