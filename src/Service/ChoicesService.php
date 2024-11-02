<?php

namespace Softify\PayumPrzelewy24Bundle\Service;

use Softify\PayumPrzelewy24Bundle\Dto\Marketplace\BusinessTypeDto;
use Softify\PayumPrzelewy24Bundle\Dto\Marketplace\TradeDto;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ChoicesService
{
    protected ParameterBagInterface $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    /**
     * @return int[]
     */
    public function getBusinessTypesValues(): array
    {
        return array_map(
            static fn(BusinessTypeDto $businessType) => $businessType->getValue(),
            $this->getBusinessTypes()
        );
    }

    /**
     * @return BusinessTypeDto[]
     */
    public function getBusinessTypes(): array
    {
        return array_map(
            static fn($item) => (new BusinessTypeDto())->setValue($item['value'])->setDescription($item['description']),
            $this->parameterBag->get('przelewy24_choices')['business_types']
        );
    }

    /**
     * @return string[]
     */
    public function getTradesValues(): array
    {
        return array_map(
            static fn(TradeDto $trade) => $trade->getValue(),
            $this->getTrades()
        );
    }

    /**
     * @return TradeDto[]
     */
    public function getTrades(): array
    {
        return array_map(
            static fn($item) => (new TradeDto())->setValue($item['value'])->setDescription($item['description']),
            $this->parameterBag->get('przelewy24_choices')['trades']
        );
    }
}
