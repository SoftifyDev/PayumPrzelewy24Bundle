<?php

namespace Softify\PayumPrzelewy24Bundle\Dto\Marketplace;

use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class AddressDto
{
    /**
     * @Assert\NotBlank()
     * @Assert\EqualTo("PL")
     */
    protected string $country = 'PL';

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=50)
     */
    protected string $city;

    /**
     * Format 00-000
     *
     * @Assert\NotBlank()
     * @Assert\Regex("/^([0-9]{2})-([0-9]{3})$/")
     * @SerializedName("post_code")
     */
    protected string $postCode;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=100)
     */
    protected string $street;

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;
        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getPostCode(): string
    {
        return $this->postCode;
    }

    public function setPostCode(string $postCode): self
    {
        $this->postCode = $postCode;
        return $this;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;
        return $this;
    }
}
