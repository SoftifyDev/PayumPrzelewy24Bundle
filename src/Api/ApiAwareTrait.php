<?php

namespace Softify\PayumPrzelewy24Bundle\Api;

use Payum\Core\Exception\UnsupportedApiException;
use Payum\Core\Request\Generic;
use Softify\PayumPrzelewy24Bundle\Entity\Payment;

trait ApiAwareTrait {

    protected ApiInterface $api;

    public function setApi($api): void
    {
        if ($api instanceof ApiInterface) {
            $this->api = $api;
            $this->paymentService->setApi($api);
            return;
        }

        throw new UnsupportedApiException();
    }

    protected function setMerchantIdFromPayment(Generic $request): void
    {
        /** @var Payment $payment */
        $payment = $request->getFirstModel();
        $this->api->setClientId($payment->getMerchantId());
    }
}
