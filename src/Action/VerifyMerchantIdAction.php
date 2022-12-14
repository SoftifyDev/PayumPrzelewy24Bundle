<?php

namespace Softify\PayumPrzelewy24Bundle\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\ApiAwareInterface;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\GatewayAwareTrait;
use Payum\Core\Security\GenericTokenFactoryAwareInterface;
use Payum\Core\Security\GenericTokenFactoryAwareTrait;
use Softify\PayumPrzelewy24Bundle\Api\ApiAwareTrait;
use Softify\PayumPrzelewy24Bundle\Request\VerifyMerchantIdRequest;
use Softify\PayumPrzelewy24Bundle\Service\MarketplaceService;
use Softify\PayumPrzelewy24Bundle\Service\PaymentService;

final class VerifyMerchantIdAction implements ApiAwareInterface, ActionInterface, GatewayAwareInterface, GenericTokenFactoryAwareInterface
{
    use GenericTokenFactoryAwareTrait;
    use GatewayAwareTrait;
    use ApiAwareTrait;

    private PaymentService $paymentService;
    private MarketplaceService $marketplaceService;

    public function __construct(PaymentService $paymentService, MarketplaceService $marketplaceService)
    {
        $this->paymentService = $paymentService;
        $this->marketplaceService = $marketplaceService;
    }

    public function execute($request): void
    {
        /** @var VerifyMerchantIdRequest $request */
        RequestNotSupportedException::assertSupports($this, $request);
        $request->setAffiliatesResponseDto($this->marketplaceService->findMerchant($request));
    }

    public function supports($request): bool
    {
        return $request instanceof VerifyMerchantIdRequest;
    }
}
