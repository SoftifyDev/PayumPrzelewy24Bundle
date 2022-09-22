<?php

namespace Softify\PayumPrzelewy24Bundle\Request;

use Softify\PayumPrzelewy24Bundle\Dto\ApiResponseInterface;

class MerchantExistsRequest
{
    protected int $value;
    protected string $type;

    public const NIP = 'nip';
    public const PESEL = 'pesel';

    protected ApiResponseInterface $merchantExistsResponseDto;

    public static function createWithNip(int $nip): self
    {
        return
            (new self())
                ->setValue($nip)
                ->setType(self::NIP);
    }

    public static function createWithPesel(int $pesel): self
    {
        return
            (new self())
                ->setValue($pesel)
                ->setType(self::PESEL);
    }

    public function isNipType(): bool
    {
        return $this->type === self::NIP;
    }

    public function isPeselType(): bool
    {
        return $this->type === self::PESEL;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getMerchantExistsResponseDto(): ApiResponseInterface
    {
        return $this->merchantExistsResponseDto;
    }

    public function setMerchantExistsResponseDto(ApiResponseInterface $merchantExistsResponseDto): self
    {
        $this->merchantExistsResponseDto = $merchantExistsResponseDto;
        return $this;
    }
}
