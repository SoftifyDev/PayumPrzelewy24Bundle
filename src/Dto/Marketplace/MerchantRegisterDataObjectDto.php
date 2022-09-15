<?php

namespace Softify\PayumPrzelewy24Bundle\Dto\Marketplace;

class MerchantRegisterDataObjectDto
{
    protected int $merchantId;
    protected string $link;

    public function getMerchantId(): int
    {
        return $this->merchantId;
    }

    public function setMerchantId(int $merchantId): MerchantRegisterDataObjectDto
    {
        $this->merchantId = $merchantId;
        return $this;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): MerchantRegisterDataObjectDto
    {
        $this->link = $link;
        return $this;
    }
}
