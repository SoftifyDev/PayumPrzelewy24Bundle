<?php

namespace Softify\PayumPrzelewy24Bundle\Dto\Marketplace;

use Symfony\Component\Validator\Constraints as Assert;

class RepresentativeDto
{
    /**
     * @Assert\Length(max=100)
     */
    protected ?string $name = null;

    /**
     * @Assert\Length(min=11,max=11)
     */
    protected ?string $pesel = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): RepresentativeDto
    {
        $this->name = $name;
        return $this;
    }

    public function getPesel(): ?string
    {
        return $this->pesel;
    }

    public function setPesel(?string $pesel): RepresentativeDto
    {
        $this->pesel = $pesel;
        return $this;
    }
}
