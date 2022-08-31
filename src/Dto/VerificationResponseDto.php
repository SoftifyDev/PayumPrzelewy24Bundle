<?php

namespace Softify\PayumPrzelewy24Bundle\Dto;

class VerificationResponseDto extends AbstractResponseDto implements ResponseDtoInterface
{
    protected StatusDto $data;

    public function getData(): StatusDto
    {
        return $this->data;
    }

    public function setData(StatusDto $data): VerificationResponseDto
    {
        $this->data = $data;
        return $this;
    }
}
