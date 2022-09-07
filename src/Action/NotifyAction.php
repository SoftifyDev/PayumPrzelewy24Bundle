<?php

namespace Softify\PayumPrzelewy24Bundle\Action;

use Doctrine\ORM\EntityManagerInterface;
use Payum\Core\Action\ActionInterface;
use Payum\Core\ApiAwareInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\GatewayAwareTrait;
use Payum\Core\Request\GetHttpRequest;
use Payum\Core\Request\GetHumanStatus;
use Payum\Core\Request\Notify;
use Softify\PayumPrzelewy24Bundle\Api\ApiAwareTrait;
use Softify\PayumPrzelewy24Bundle\Api\ApiInterface;
use Softify\PayumPrzelewy24Bundle\Dto\ApiResponseInterface;
use Softify\PayumPrzelewy24Bundle\Dto\ErrorResponseDto;
use Softify\PayumPrzelewy24Bundle\Dto\Marketplace\CrcResponseDto;
use Softify\PayumPrzelewy24Bundle\Dto\Payment\NotificationDto as TransactionNotificationRequest;
use Softify\PayumPrzelewy24Bundle\Dto\Payment\VerificationResponseDto;
use Softify\PayumPrzelewy24Bundle\Dto\Refund\NotificationDto as RefundNotificationDto;
use Softify\PayumPrzelewy24Bundle\Entity\Payment;
use Softify\PayumPrzelewy24Bundle\Event\PaymentStatusEvent;
use Softify\PayumPrzelewy24Bundle\Service\PaymentService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class NotifyAction implements ActionInterface, ApiAwareInterface, GatewayAwareInterface
{
    use GatewayAwareTrait;
    use ApiAwareTrait;

    private PaymentService $paymentService;
    private EntityManagerInterface $entityManager;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(
        PaymentService $paymentService,
        EntityManagerInterface $entityManager,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->paymentService = $paymentService;
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute($request): void
    {
        /** @var Notify $request */
        RequestNotSupportedException::assertSupports($this, $request);

        $this->setMerchantIdFromPayment($request);

        /** @var Notify $request */
        $model = $request->getModel();
        /** @var Payment $payment */
        $payment = $request->getFirstModel();

        $httpRequest = $this->getHttpRequest();
        switch ($httpRequest->query['type']) {
            case 'refund':
                $notificationDto = $this->paymentService->deserializeRefundNotification($httpRequest->content);
                $this->verifyRefundNotificationRequest($request, $notificationDto);
                $model['state'] = ApiInterface::REFUNDED_STATUS;
                break;
            case 'transaction':
                $notificationDto = $this->paymentService->deserializeTransactionNotification($httpRequest->content);
                $this->verifyTransactionNotificationRequest($request, $notificationDto);

                /** @var ErrorResponseDto $response */
                $response = $this->paymentService->verifyTransaction($request, $notificationDto);
                if ($response instanceof VerificationResponseDto) {
                    $model['orderId'] = $notificationDto->getOrderId();
                    $model['methodId'] = $notificationDto->getMethodId();
                    $model['statement'] = $notificationDto->getStatement();
                    $model['state'] = $response->getData()->getStatus() === ApiInterface::STATUS_SUCCESS
                        ? ApiInterface::COMPLETED_STATUS : ApiInterface::FAILED_STATUS;
                }
                break;
        }
        $payment->setDetails($model);
        $request->setModel($model);

        $this->gateway->execute($status = new GetHumanStatus($payment));
        $event = new PaymentStatusEvent($payment->getStatus(), $payment);
        $payment->setStatus($status->getValue());
        $this->entityManager->persist($payment);
        $this->eventDispatcher->dispatch($event);
    }

    public function supports($request): bool
    {
        return
            $request instanceof Notify
            && $request->getModel() instanceof ArrayObject;
    }

    private function getHttpRequest(): GetHttpRequest
    {
        $this->gateway->execute($httpRequest = new GetHttpRequest());
        return $httpRequest;
    }

    private function verifyRefundNotificationRequest(Notify $request, RefundNotificationDto $notificationDto): void
    {
        $model = $request->getModel();
        $crcResponse = $this->getCrc();
        if (
            $crcResponse instanceof CrcResponseDto
            && $notificationDto->getRefundsUuid() === $model['refundsUuid']
            && $notificationDto->verify($crcResponse->getData()->getCrc())
        ) {
            return;
        }
        throw RequestNotSupportedException::createActionNotSupported($this, $request);
    }

    private function verifyTransactionNotificationRequest(Notify $request, TransactionNotificationRequest $notificationDto): void
    {
        $crcResponse = $this->getCrc();
        if ($crcResponse instanceof CrcResponseDto && $notificationDto->verify($crcResponse->getData()->getCrc())) {
            return;
        }
        throw RequestNotSupportedException::createActionNotSupported($this, $request);
    }

    private function getCrc(): ApiResponseInterface
    {
        return $this->paymentService->getMarketplaceService()->getCRCKey($this->api->getClientId());
    }
}
