<?php

namespace Softify\PayumPrzelewy24Bundle\Dto\Marketplace;

class DataAffArrayObjectDto
{
    protected int $id;
    protected string $name;
    protected string $nip;
    protected string $regon;
    protected string $customerStatus;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): DataAffArrayObjectDto
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): DataAffArrayObjectDto
    {
        $this->name = $name;
        return $this;
    }

    public function getNip(): string
    {
        return $this->nip;
    }

    public function setNip(string $nip): DataAffArrayObjectDto
    {
        $this->nip = $nip;
        return $this;
    }

    public function getRegon(): string
    {
        return $this->regon;
    }

    public function setRegon(string $regon): DataAffArrayObjectDto
    {
        $this->regon = $regon;
        return $this;
    }

    public function getCustomerStatus(): string
    {
        return $this->customerStatus;
    }

    public function setCustomerStatus(string $customerStatus): DataAffArrayObjectDto
    {
        $this->customerStatus = $customerStatus;
        return $this;
    }
}
