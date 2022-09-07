<?php

namespace Softify\PayumPrzelewy24Bundle\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\ApiAwareInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\GatewayAwareTrait;
use Payum\Core\Request\Refund;
use Payum\Core\Security\GenericTokenFactoryAwareInterface;
use Payum\Core\Security\GenericTokenFactoryAwareTrait;
use Softify\PayumPrzelewy24Bundle\Api\ApiAwareTrait;
use Softify\PayumPrzelewy24Bundle\Dto\ErrorResponseInterface;
use Softify\PayumPrzelewy24Bundle\Dto\Refund\RefundResponseDto;
use Softify\PayumPrzelewy24Bundle\Entity\Payment;
use Softify\PayumPrzelewy24Bundle\Exception\PaymentException;
use Softify\PayumPrzelewy24Bundle\Service\PaymentService;

final class RefundAction implements ApiAwareInterface, ActionInterface, GatewayAwareInterface, GenericTokenFactoryAwareInterface
{
    use GenericTokenFactoryAwareTrait;
    use GatewayAwareTrait;
    use ApiAwareTrait;

    private PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function execute($request): void
    {
        /** @var Refund $request */
        RequestNotSupportedException::assertSupports($this, $request);
        $this->setMerchantIdFromPayment($request);

        /** @var Payment $payment */
        $payment = $request->getModel();
        $details = ArrayObject::ensureArrayObject($payment->getDetails());
        if ($details['refundsUuid'] === null) {
            /** @var ErrorResponseInterface $response */
            $response = $this->paymentService->refundTransaction($request);
            if ($response instanceof RefundResponseDto) {
                $request->setModel($payment);
                return;
            }
            throw PaymentException::newInstanceFromErrorResponse($response);
        }
    }

    public function supports($request): bool
    {
        return $request instanceof Refund;
    }
}
