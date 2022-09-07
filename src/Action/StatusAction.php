<?php

namespace Softify\PayumPrzelewy24Bundle\Action;

use Doctrine\ORM\EntityManagerInterface;
use Payum\Core\Action\ActionInterface;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\GatewayAwareTrait;
use Payum\Core\Model\PaymentInterface;
use Payum\Core\Request\GetHttpRequest;
use Payum\Core\Request\GetHumanStatus;
use Payum\Core\Request\GetStatusInterface;
use Softify\PayumPrzelewy24Bundle\Api\ApiInterface;
use Softify\PayumPrzelewy24Bundle\Entity\Payment;
use Softify\PayumPrzelewy24Bundle\Event\PaymentStatusEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class StatusAction implements ActionInterface, GatewayAwareInterface
{
    use GatewayAwareTrait;

    private EntityManagerInterface $entityManager;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EntityManagerInterface $entityManager, EventDispatcherInterface $eventDispatcher)
    {
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute($request): void
    {
        RequestNotSupportedException::assertSupports($this, $request);

        /** @var GetStatusInterface $request */
        /** @var Payment $payment */
        $payment = $request->getModel();

        $details = $payment->getDetails();

        $this->gateway->execute($httpRequest = new GetHttpRequest());

        if (isset($httpRequest->query['status'])) {
            $status = null;
            if (ApiInterface::CANCELLED_STATUS === $httpRequest->query['status']) {
                $details['state'] = ApiInterface::CANCELLED_STATUS;
                $status = GetHumanStatus::STATUS_CANCELED;
                $request->markCanceled();
            } elseif (ApiInterface::PENDING_STATUS === $httpRequest->query['status']) {
                $details['state'] = ApiInterface::PENDING_STATUS;
                $status = GetHumanStatus::STATUS_PENDING;
                $request->markPending();
            }
            if ($status) {
                $event = new PaymentStatusEvent($payment->getStatus(), $payment);
                $payment->setDetails($details);
                $payment->setStatus($status);
                $request->setModel($payment);
                $this->entityManager->persist($payment);
                $this->eventDispatcher->dispatch($event);
            }
            return;
        }

        if (false === isset($details['state'])) {
            $request->markNew();
            return;
        }

        if (ApiInterface::COMPLETED_STATUS === $details['state']) {
            $request->markCaptured();
            return;
        }

        if (ApiInterface::REFUNDED_STATUS === $details['state']) {
            $request->markRefunded();
            return;
        }

        if (
            ApiInterface::CREATED_STATUS === $details['state']
            || ApiInterface::PENDING_STATUS === $details['state']
        ) {
            $request->markPending();
            return;
        }

        if (ApiInterface::FAILED_STATUS === $details['state']) {
            $request->markFailed();
            return;
        }

        $request->markUnknown();
    }

    /**
     * @param mixed $request
     *
     * @return boolean
     */
    public function supports($request)
    {
        return
            $request instanceof GetStatusInterface &&
            $request->getModel() instanceof PaymentInterface;
    }
}
