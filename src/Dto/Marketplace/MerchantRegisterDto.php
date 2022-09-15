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
     * The parameter is available only to selected Partners.
     */
    protected bool $acceptance = false;

    /**
     * @var RepresentativeDto[]
     * @Assert\Valid()
     */
    protected array $representatives = [];

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=50)
     * @SerializedName("contact_person[name]")
     */
    protected string $contactPersonName;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=50)
     * @Assert\Email()
     * @SerializedName("contact_person[email]")
     */
    protected string $contactPersonEmail;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=9)
     * @SerializedName("contact_person[phone_number]")
     */
    protected string $contactPersonPhoneNumber;

    /**
     * @Assert\NotBlank()
     * @SerializedName("technical_contact[name]")
     */
    protected string $technicalContactName;

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     * @SerializedName("technical_contact[email]")
     */
    protected string $technicalContactEmail;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=9)
     * @SerializedName("technical_contact[phone_number]")
     */
    protected string $technicalContactPhoneNumber;

    /**
     * @Assert\NotBlank()
     * @Assert\EqualTo("PL")
     * @SerializedName("address[country]")
     */
    protected string $addressCountry = 'PL';

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=50)
     * @SerializedName("address[city]")
     */
    protected string $addressCity;

    /**
     * Format 00-000
     *
     * @Assert\NotBlank()
     * @Assert\Regex("/^([0-9]{2})-([0-9]{3})$/")
     * @SerializedName("address[post_code]")
     */
    protected string $addressPostCode;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=100)
     * @SerializedName("address[street]")
     */
    protected string $addressStreet;

    /**
     * @Assert\NotBlank()
     * @Assert\EqualTo("PL")
     * @SerializedName("correspondence_address[country]")
     */
    protected string $correspondenceAddressCountry = 'PL';

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=50)
     * @SerializedName("correspondence_address[city]")
     */
    protected string $correspondenceAddressCity;

    /**
     * Format 00-000
     * @Assert\NotBlank()
     * @Assert\Regex("/^([0-9]{2})-([0-9]{3})$/")
     * @SerializedName("correspondence_address[post_code]")
     */
    protected string $correspondenceAddressPostCode;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=100)
     * @SerializedName("correspondence_address[street]")
     */
    protected string $correspondenceAddressStreet;

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

    public function isAcceptance(): bool
    {
        return $this->acceptance;
    }

    public function setAcceptance(bool $acceptance): MerchantRegisterDto
    {
        $this->acceptance = $acceptance;
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

    public function getContactPersonName(): string
    {
        return $this->contactPersonName;
    }

    public function setContactPersonName(string $contactPersonName): MerchantRegisterDto
    {
        $this->contactPersonName = $contactPersonName;
        return $this;
    }

    public function getContactPersonEmail(): string
    {
        return $this->contactPersonEmail;
    }

    public function setContactPersonEmail(string $contactPersonEmail): MerchantRegisterDto
    {
        $this->contactPersonEmail = $contactPersonEmail;
        return $this;
    }

    public function getContactPersonPhoneNumber(): string
    {
        return $this->contactPersonPhoneNumber;
    }

    public function setContactPersonPhoneNumber(string $contactPersonPhoneNumber): MerchantRegisterDto
    {
        $this->contactPersonPhoneNumber = $contactPersonPhoneNumber;
        return $this;
    }

    public function getTechnicalContactName(): string
    {
        return $this->technicalContactName;
    }

    public function setTechnicalContactName(string $technicalContactName): MerchantRegisterDto
    {
        $this->technicalContactName = $technicalContactName;
        return $this;
    }

    public function getTechnicalContactEmail(): string
    {
        return $this->technicalContactEmail;
    }

    public function setTechnicalContactEmail(string $technicalContactEmail): MerchantRegisterDto
    {
        $this->technicalContactEmail = $technicalContactEmail;
        return $this;
    }

    public function getTechnicalContactPhoneNumber(): string
    {
        return $this->technicalContactPhoneNumber;
    }

    public function setTechnicalContactPhoneNumber(string $technicalContactPhoneNumber): MerchantRegisterDto
    {
        $this->technicalContactPhoneNumber = $technicalContactPhoneNumber;
        return $this;
    }

    public function getAddressCountry(): string
    {
        return $this->addressCountry;
    }

    public function setAddressCountry(string $addressCountry): MerchantRegisterDto
    {
        $this->addressCountry = $addressCountry;
        return $this;
    }

    public function getAddressCity(): string
    {
        return $this->addressCity;
    }

    public function setAddressCity(string $addressCity): MerchantRegisterDto
    {
        $this->addressCity = $addressCity;
        return $this;
    }

    public function getAddressPostCode(): string
    {
        return $this->addressPostCode;
    }

    public function setAddressPostCode(string $addressPostCode): MerchantRegisterDto
    {
        $this->addressPostCode = $addressPostCode;
        return $this;
    }

    public function getAddressStreet(): string
    {
        return $this->addressStreet;
    }

    public function setAddressStreet(string $addressStreet): MerchantRegisterDto
    {
        $this->addressStreet = $addressStreet;
        return $this;
    }

    public function getCorrespondenceAddressCountry(): string
    {
        return $this->correspondenceAddressCountry;
    }

    public function setCorrespondenceAddressCountry(string $correspondenceAddressCountry): MerchantRegisterDto
    {
        $this->correspondenceAddressCountry = $correspondenceAddressCountry;
        return $this;
    }

    public function getCorrespondenceAddressCity(): string
    {
        return $this->correspondenceAddressCity;
    }

    public function setCorrespondenceAddressCity(string $correspondenceAddressCity): MerchantRegisterDto
    {
        $this->correspondenceAddressCity = $correspondenceAddressCity;
        return $this;
    }

    public function getCorrespondenceAddressPostCode(): string
    {
        return $this->correspondenceAddressPostCode;
    }

    public function setCorrespondenceAddressPostCode(string $correspondenceAddressPostCode): MerchantRegisterDto
    {
        $this->correspondenceAddressPostCode = $correspondenceAddressPostCode;
        return $this;
    }

    public function getCorrespondenceAddressStreet(): string
    {
        return $this->correspondenceAddressStreet;
    }

    public function setCorrespondenceAddressStreet(string $correspondenceAddressStreet): MerchantRegisterDto
    {
        $this->correspondenceAddressStreet = $correspondenceAddressStreet;
        return $this;
    }
}
