<?php

namespace Softify\PayumPrzelewy24Bundle\Action;

use Softify\PayumPrzelewy24Bundle\Entity\Payment;
use Symfony\Contracts\EventDispatcher\Event;

class PaymentStatusEvent extends Event
{
    protected string $previousStatus;
    protected Payment $payment;

    public function __construct(string $previousStatus, Payment $payment)
    {
        $this->previousStatus = $previousStatus;
        $this->payment = $payment;
    }

    public function getPreviousStatus(): string
    {
        return $this->previousStatus;
    }

    public function getPayment(): Payment
    {
        return $this->payment;
    }
}
