<?php

namespace Softify\PayumPrzelewy24Bundle\Api;

use Payum\Core\Exception\UnsupportedApiException;

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
}
