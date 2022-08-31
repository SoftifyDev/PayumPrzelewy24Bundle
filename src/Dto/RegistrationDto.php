<?php

namespace Softify\PayumPrzelewy24Bundle\Dto;

class RegistrationDto
{
    protected int $merchantId;
    protected int $posId;
    protected string $sessionId;
    protected int $amount;
    protected string $currency = 'PLN';
    protected string $description;
    protected string $email;
    protected ?string $client = null;
    protected ?string $address = null;
    protected ?string $zip = null;
    protected ?string $city = null;
    protected string $country = 'PL';
    protected string $phone;
    protected string $language = 'pl';
    protected string $urlReturn;
    protected string $urlCancel;
    protected string $urlStatus;
    protected int $timeLimit = 0;
    protected bool $waitForResult = false;
    protected string $sign;

    public function getMerchantId(): int
    {
        return $this->merchantId;
    }

    public function setMerchantId(int $merchantId): RegistrationDto
    {
        $this->merchantId = $merchantId;
        return $this;
    }

    public function getPosId(): int
    {
        return $this->posId;
    }

    public function setPosId(int $posId): RegistrationDto
    {
        $this->posId = $posId;
        return $this;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function setSessionId(string $sessionId): RegistrationDto
    {
        $this->sessionId = $sessionId;
        return $this;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): RegistrationDto
    {
        $this->amount = $amount;
        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): RegistrationDto
    {
        $this->currency = $currency;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): RegistrationDto
    {
        $this->description = $description;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): RegistrationDto
    {
        $this->email = $email;
        return $this;
    }

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(?string $client): RegistrationDto
    {
        $this->client = $client;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): RegistrationDto
    {
        $this->address = $address;
        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(?string $zip): RegistrationDto
    {
        $this->zip = $zip;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): RegistrationDto
    {
        $this->city = $city;
        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): RegistrationDto
    {
        $this->country = $country;
        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): RegistrationDto
    {
        $this->phone = $phone;
        return $this;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): RegistrationDto
    {
        $this->language = $language;
        return $this;
    }

    public function getUrlReturn(): string
    {
        return $this->urlReturn;
    }

    public function getUrlCancel(): string
    {
        return $this->urlCancel;
    }

    public function setUrlCancel(string $urlCancel): RegistrationDto
    {
        $this->urlCancel = $urlCancel;
        return $this;
    }

    public function setUrlReturn(string $urlReturn): RegistrationDto
    {
        $this->urlReturn = $urlReturn;
        return $this;
    }

    public function getUrlStatus(): string
    {
        return $this->urlStatus;
    }

    public function setUrlStatus(string $urlStatus): RegistrationDto
    {
        $this->urlStatus = $urlStatus;
        return $this;
    }

    public function getTimeLimit(): int
    {
        return $this->timeLimit;
    }

    public function setTimeLimit(int $timeLimit): RegistrationDto
    {
        $this->timeLimit = $timeLimit;
        return $this;
    }

    public function isWaitForResult(): bool
    {
        return $this->waitForResult;
    }

    public function setWaitForResult(bool $waitForResult): RegistrationDto
    {
        $this->waitForResult = $waitForResult;
        return $this;
    }

    public function getSign(): string
    {
        return $this->sign;
    }

    public function setSign(string $sign): RegistrationDto
    {
        $this->sign = $sign;
        return $this;
    }

    public function countSignAndSet(string $clientSecret): RegistrationDto
    {
        $data = [
            'sessionId' => $this->sessionId,
            'merchantId' => $this->merchantId,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'crc' => $clientSecret,
        ];

        $this->sign = hash('sha384', json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        return $this;
    }
}
