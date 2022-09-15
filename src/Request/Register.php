<?php

namespace Softify\PayumPrzelewy24Bundle\Request;

use Softify\PayumPrzelewy24Bundle\Dto\ApiResponseInterface;
use Softify\PayumPrzelewy24Bundle\Dto\Marketplace\MerchantRegisterDto;

class Register
{
    protected MerchantRegisterDto $merchantRegister;
    protected ApiResponseInterface $apiResponse;

    public function __construct(MerchantRegisterDto $merchantRegister)
    {
        $this->merchantRegister = $merchantRegister;
    }

    public function getMerchantRegister(): MerchantRegisterDto
    {
        return $this->merchantRegister;
    }

    public function getApiResponse(): ApiResponseInterface
    {
        return $this->apiResponse;
    }

    public function setApiResponse(ApiResponseInterface $apiResponse): Register
    {
        $this->apiResponse = $apiResponse;
        return $this;
    }
}
