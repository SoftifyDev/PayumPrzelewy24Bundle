<?php

namespace Softify\PayumPrzelewy24Bundle\Dto\Marketplace;

class CrcDataObjectDto
{
    protected int $id;
    protected string $crc;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): CrcDataObjectDto
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
