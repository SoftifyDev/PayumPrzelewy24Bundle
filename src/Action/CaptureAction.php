<?php

namespace Softify\PayumPrzelewy24Bundle\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\ApiAwareInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\GatewayAwareTrait;
use Payum\Core\Request\Capture;
use Payum\Core\Security\GenericTokenFactoryAwareInterface;
use Payum\Core\Security\GenericTokenFactoryAwareTrait;
use Softify\PayumPrzelewy24Bundle\Api\ApiAwareTrait;
use Payum\Core\Security\TokenInterface;
use Payum\Core\Reply\HttpRedirect;
use Softify\PayumPrzelewy24Bundle\Api\ApiInterface;
use Softify\PayumPrzelewy24Bundle\Dto\ErrorResponseDto;
use Softify\PayumPrzelewy24Bundle\Dto\Payment\TransactionResponseDto;
use Softify\PayumPrzelewy24Bundle\Exception\PaymentException;
use Softify\PayumPrzelewy24Bundle\Service\PaymentService;

final class CaptureAction implements ApiAwareInterface, ActionInterface, GatewayAwareInterface, GenericTokenFactoryAwareInterface
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
        /** @var Capture $request */
        RequestNotSupportedException::assertSupports($this, $request);

        $this->setMerchantIdFromPayment($request);
        /** @var ArrayObject $model */
        $model = $request->getModel();
        /** @var TokenInterface $token */
        $token = $request->getToken();
        if ($model['urlPayment'] === null || ($model['urlPayment'] && $model['state'] === ApiInterface::CREATED_STATUS)) {
            if ($model['urlPayment'] === null) {
                $notifyToken = $this->createNotifyToken($token->getGatewayName(), $request->getFirstModel());
                $model['urlStatus'] = $notifyToken->getTargetUrl();
                $request->setModel($model);

                /** @var ErrorResponseDto $response */
                $response = $this->paymentService->registerTransaction($request, $model['urlStatus']);
                if ($response instanceof TransactionResponseDto) {
                    $model['paymentId'] = $response->getData()->getToken();
                    $model['state'] = ApiInterface::CREATED_STATUS;
                    $model['urlPayment'] = sprintf(
                        '%s/trnRequest/%s',
                        $this->api->getUrl(),
                        $model['paymentId']
                    );
                    $request->setModel($model);
                } else {
                    throw PaymentException::newInstanceFromErrorResponse($response);
                }
            }
            throw new HttpRedirect($model['urlPayment']);
        }
        if (!$this->api->invalidateCaptureToken()) {
            throw new HttpRedirect($token->getAfterUrl());
        }
    }

    protected function createNotifyToken(string $gatewayName, object $model): TokenInterface
    {
        return $this->tokenFactory->createNotifyToken($gatewayName, $model);
    }

    public function supports($request): bool
    {
        return $request instanceof Capture && $request->getModel() instanceof ArrayObject;
    }
}
