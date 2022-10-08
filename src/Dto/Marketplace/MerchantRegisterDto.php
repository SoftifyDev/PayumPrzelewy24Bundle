<?php

namespace Softify\PayumPrzelewy24Bundle\Dto\Marketplace;

use Symfony\Component\Validator\Constraints as Assert;
use Softify\PayumPrzelewy24Bundle\Validator\Constraints as SoftifyAssert;
use Symfony\Component\Serializer\Annotation\SerializedName;

class MerchantRegisterDto
{
    /**
     * @Assert\NotBlank()
     * @SoftifyAssert\Choice(callback="getBusinessTypesValues")
     * @SerializedName("business_type")
     */
    protected int $businessType = 0;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=255)
     */
    protected string $name;

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     * @Assert\Length(max=50)
     */
    protected string $email;

    /**
     * Required in case natural person is registered (business_type = 1)
     *
     * @Assert\Length(min=11, max=11)
     * @Assert\Expression(
     *     "!(this.getBusinessType() === 1 and !this.getPesel())",
     *     message="This value should not be blank."
     * )
     */
    protected ?string $pesel = null;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=9, max=9)
     * @SerializedName("phone_number")
     */
    protected string $phoneNumber;

    /**
     * @Assert\NotBlank()
     * @SerializedName("bank_account")
     */
    protected string $bankAccount;

    /**
     * @Assert\NotBlank()
     * @SerializedName("invoice_email")
     */
    protected string $invoiceEmail;

    /**
     * The parameter is not required, if parameter services_description is send
     *
     * @Assert\Url()
     * @Assert\Expression(
     *     "!(!this.getServicesDescription() && !this.getShopUrl())",
     *     message="This value should not be blank."
     * )
     * @SerializedName("shop_url")
     */
    protected ?string $shopUrl = null;

    /**
     * The parameter is not required, if parameter shop_url is send
     *
     * @Assert\Expression(
     *     "!(!this.getServicesDescription() && !this.getShopUrl())",
     *     message="This value should not be blank."
     * )
     * @SerializedName("services_description")
     */
    protected ?string $servicesDescription = null;

    /**
     * @Assert\NotBlank()
     * @SoftifyAssert\Choice(callback="getTradesValues")
     */
    protected string $trade;

    /**
     * Required only if business_type > 3
     *
     * @Assert\Length(min=10, max=10)
     * @Assert\Expression(
     *     "!(this.getBusinessType() > 3 and !this.getKrs())",
     *     message="This value should not be blank."
     * )
     */
    protected ?string $krs = null;

    /**
     * Required only if business_type != 1
     *
     * @Assert\Length(min=10, max=10)
     * @Assert\Expression(
     *     "!(this.getBusinessType() !== 1 and !this.getNip())",
     *     message="This value should not be blank."
     * )
     */
    protected ?string $nip = null;

    /**
     * Required only if business_type != 1
     *
     * @Assert\Length(max=14)
     * @Assert\Expression(
     *     "!(this.getBusinessType() !== 1 and !this.getRegon())",
     *     message="This value should not be blank."
     * )
     */
    protected ?string $regon = null;

    /**
     * @var RepresentativeDto[]
     * @Assert\Valid()
     */
    protected array $representatives = [];

    /**
     * @Assert\NotBlank()
     * @Assert\Valid()
     * @SerializedName("contact_person")
     */
    protected ContactDto $contactPerson;

    /**
     * @Assert\NotBlank()
     * @Assert\Valid()
     * @SerializedName("technical_contact")
     */
    protected ContactDto $technicalContact;

    /**
     * @Assert\NotBlank()
     * @Assert\Valid()
     */
    protected AddressDto $address;

    /**
     * @Assert\NotBlank()
     * @Assert\Valid()
     * @SerializedName("correspondence_address")
     */
    protected AddressDto $correspondenceAddress;

    public function getBusinessType(): int
    {
        return $this->businessType;
    }

    public function setBusinessType(int $businessType): MerchantRegisterDto
    {
        $this->businessType = $businessType;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): MerchantRegisterDto
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): MerchantRegisterDto
    {
        $this->email = $email;
        return $this;
    }

    public function getPesel(): ?string
    {
        return $this->pesel;
    }

    public function setPesel(string $pesel): MerchantRegisterDto
    {
        $this->pesel = $pesel;
        return $this;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): MerchantRegisterDto
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function getBankAccount(): string
    {
        return $this->bankAccount;
    }

    public function setBankAccount(string $bankAccount): MerchantRegisterDto
    {
        $this->bankAccount = $bankAccount;
        return $this;
    }

    public function getInvoiceEmail(): string
    {
        return $this->invoiceEmail;
    }

    public function setInvoiceEmail(string $invoiceEmail): MerchantRegisterDto
    {
        $this->invoiceEmail = $invoiceEmail;
        return $this;
    }

    public function getShopUrl(): ?string
    {
        return $this->shopUrl;
    }

    public function setShopUrl(string $shopUrl): MerchantRegisterDto
    {
        $this->shopUrl = $shopUrl;
        return $this;
    }

    public function getServicesDescription(): ?string
    {
        return $this->servicesDescription;
    }

    public function setServicesDescription(string $servicesDescription): MerchantRegisterDto
    {
        $this->servicesDescription = $servicesDescription;
        return $this;
    }

    public function getTrade(): string
    {
        return $this->trade;
    }

    public function setTrade(string $trade): MerchantRegisterDto
    {
        $this->trade = $trade;
        return $this;
    }

    public function getKrs(): ?string
    {
        return $this->krs;
    }

    public function setKrs(string $krs): MerchantRegisterDto
    {
        $this->krs = $krs;
        return $this;
    }

    public function getNip(): ?string
    {
        return $this->nip;
    }

    public function setNip(string $nip): MerchantRegisterDto
    {
        $this->nip = $nip;
        return $this;
    }

    public function getRegon(): ?string
    {
        return $this->regon;
    }

    public function setRegon(string $regon): MerchantRegisterDto
    {
        $this->regon = $regon;
        return $this;
    }

    public function getRepresentatives(): array
    {
        return $this->representatives;
    }

    public function setRepresentatives(array $representatives): MerchantRegisterDto
    {
        $this->representatives = $representatives;
        return $this;
    }

    public function getContactPerson(): ContactDto
    {
        return $this->contactPerson;
    }

    public function setContactPerson(ContactDto $contactPerson): MerchantRegisterDto
    {
        $this->contactPerson = $contactPerson;
        return $this;
    }

    public function getTechnicalContact(): ContactDto
    {
        return $this->technicalContact;
    }

    public function setTechnicalContact(ContactDto $technicalContact): MerchantRegisterDto
    {
        $this->technicalContact = $technicalContact;
        return $this;
    }

    public function getAddress(): AddressDto
    {
        return $this->address;
    }

    public function setAddress(AddressDto $address): MerchantRegisterDto
    {
        $this->address = $address;
        return $this;
    }

    public function getCorrespondenceAddress(): AddressDto
    {
        return $this->correspondenceAddress;
    }

    public function setCorrespondenceAddress(AddressDto $correspondenceAddress): MerchantRegisterDto
    {
        $this->correspondenceAddress = $correspondenceAddress;
        return $this;
    }
}
