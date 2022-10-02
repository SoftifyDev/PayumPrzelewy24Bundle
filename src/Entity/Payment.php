<?php

namespace Softify\PayumPrzelewy24Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Payum\Core\Model\Payment as BasePayment;

/**
 * @ORM\MappedSuperclass()
 */
abstract class Payment extends BasePayment
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected int $id;

    /**
     * @ORM\Column(name="status", type="string")
     */
    protected string $status;

    /**
     * @ORM\Column(name="merchant_id", type="integer", nullable=true)
     */
    protected ?int $merchantId = null;

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getMerchantId(): ?int
    {
        return $this->merchantId;
    }

    public function setMerchantId(?int $merchantId): Payment
    {
        $this->merchantId = $merchantId;
        return $this;
    }
}

