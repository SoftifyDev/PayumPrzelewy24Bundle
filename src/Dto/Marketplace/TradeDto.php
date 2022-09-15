<?php

namespace Softify\PayumPrzelewy24Bundle\Dto\Marketplace;

class TradeDto
{
    protected string $value;
    protected string $description;

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): TradeDto
    {
        $this->value = $value;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): TradeDto
    {
        $this->description = $description;
        return $this;
    }
}
