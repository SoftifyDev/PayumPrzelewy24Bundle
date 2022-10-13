<?php

namespace Softify\PayumPrzelewy24Bundle\Dto\Marketplace;

class CrcDataObjectDto
{
    protected string $id;
    protected string $crc;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): CrcDataObjectDto
    {
        $this->id = $id;
        return $this;
    }

    public function getCrc(): string
    {
        return $this->crc;
    }

    public function setCrc(string $crc): CrcDataObjectDto
    {
        $this->crc = $crc;
        return $this;
    }
}
