<?php

namespace Softify\PayumPrzelewy24Bundle\Dto\Marketplace;

use Softify\PayumPrzelewy24Bundle\Dto\ApiResponseInterface;

class AffiliatesResponseDto implements ApiResponseInterface
{
    /**
     * @var DataAffArrayObjectDto[]
     */
    protected array $data = [];
    protected int $code;

    /**
     * @return DataAffArrayObjectDto[]
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param DataAffArrayObjectDto[] $data
     */
    public function setData(array $data): AffiliatesResponseDto
    {
        $this->data = $data;
        return $this;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): AffiliatesResponseDto
    {
        $this->code = $code;
        return $this;
    }
}
