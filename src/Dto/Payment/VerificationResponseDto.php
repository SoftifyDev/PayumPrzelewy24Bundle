<?php

namespace Softify\PayumPrzelewy24Bundle\Dto\Payment;

use Softify\PayumPrzelewy24Bundle\Dto\ApiResponseInterface;

class VerificationResponseDto extends AbstractResponseDto implements ApiResponseInterface
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
