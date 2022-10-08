<?php

namespace Softify\PayumPrzelewy24Bundle\Dto\Marketplace;

use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class ContactDto
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=50)
     */
    protected string $name;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=50)
     * @Assert\Email()
     */
    protected string $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=9)
     * @SerializedName("phone_number")
     */
    protected string $phoneNumber;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }
}
