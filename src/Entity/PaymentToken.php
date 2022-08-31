<?php

namespace Softify\PayumPrzelewy24Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Payum\Core\Model\Token;

/**
 * @ORM\MappedSuperclass()
 */
abstract class PaymentToken extends Token
{
}

