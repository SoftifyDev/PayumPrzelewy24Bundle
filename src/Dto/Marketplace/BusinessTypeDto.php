<?php

namespace Softify\PayumPrzelewy24Bundle\Dto\Marketplace;

class BusinessTypeDto
{
    protected int $value;
    protected string $description;

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): BusinessTypeDto
    {
        $this->value = $value;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): BusinessTypeDto
    {
        $this->description = $description;
        return $this;
    }
}
