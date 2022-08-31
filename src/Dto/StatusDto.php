<?php

namespace Softify\PayumPrzelewy24Bundle\Dto;

class StatusDto
{
    protected string $status;

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): StatusDto
    {
        $this->status = $status;
        return $this;
    }
}
