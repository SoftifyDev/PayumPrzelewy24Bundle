<?php

namespace Softify\PayumPrzelewy24Bundle\Api;

interface ApiInterface
{
    public const ENVIRONMENT_SANDBOX = 'sandbox';
    public const ENVIRONMENT_PRODUCTION = 'production';

    public const URL_PRODUCTION = 'https://secure.przelewy24.pl/';
    public const URL_SANDBOX = 'https://sandbox.przelewy24.pl/';

    public const API_URL_PRODUCTION = 'https://secure.przelewy24.pl/api/v1';
    public const API_URL_SANDBOX = 'https://sandbox.przelewy24.pl/api/v1';

    public const STATUS_SUCCESS = 'success';
    public const STATUS_FAILED = 'err00';

    public const COMPLETED_STATUS = 'completed';
    public const FAILED_STATUS = 'failed';
    public const CANCELLED_STATUS = 'cancelled';
    public const CREATED_STATUS = 'created';
    public const PENDING_STATUS = 'pending';

    public const URI_TRANSACTION_REGISTER = 'transaction/register';
    public const URI_TRANSACTION_VERIFY = 'transaction/verify';
    public const URI_TEST_ACCESS = 'testAccess';
    public const URI_TRANSACTION_REFUND = 'transaction/refund';

    public const CURRENCY = 'PLN';

    public function getUrl(): string;
    public function getApiUrl(): string;
    public function getClientId(): int;
    public function getClientSecret(): string;
    public function getApiKey(): string;
    public function getAuthData(): array;
}
