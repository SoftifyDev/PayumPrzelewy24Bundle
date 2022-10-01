<?php

namespace Softify\PayumPrzelewy24Bundle\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Softify\PayumPrzelewy24Bundle\Request\PaymentDetailsRequest;

final class PaymentDetailsAction implements ActionInterface
{
    public function execute($request): void
    {
        RequestNotSupportedException::assertSupports($this, $request);
    }

    public function supports($request): bool
    {
        return
            $request instanceof PaymentDetailsRequest
            && $request->getModel() instanceof ArrayObject;
    }
}
