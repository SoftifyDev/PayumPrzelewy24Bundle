<p align="center">
    <a href="https://www.przelewy24.pl/" target="_blank">
        <img src="https://www.przelewy24.pl/themes/przelewy24/assets/img/base/przelewy24_logo_2022.svg" />
    </a>
</p>

<h1 align="center">Payum Przelewy24 bundle</h1>

<p align="center">Payum Bundle for Przelewy24 online payment.</p>

## Overview

The bundle integrates <a href="https://www.przelewy24.pl/">Przelewy24</a> payments with Symfony based applications. After the installation you should be able to create a payment method for przelewy24 gateway and enable its payments in your web application. Bundle also supports online refunds and marketplace.

## Installation

1. Run `composer require softify/payum-przelewy24-bundle`.

2. Add bundle dependencies to your config/bundles.php file:

 ```php
    return [
        Softify\PayumPrzelewy24Bundle\PayumPrzelewy24Bundle::class => ['all' => true],
    ]
```
3. Add PayumBundle routing to main configuration

```yaml
payum_all:
    resource: "@PayumBundle/Resources/config/routing/all.xml"
```

## Configuration

Create entities based on models from bundle

```php

namespace App\Entity;

use Softify\PayumPrzelewy24Bundle\Entity\Payment as BasePayment;

class Payment extends BasePayment
{
}

```

```php

namespace App\Entity;

use Softify\PayumPrzelewy24Bundle\Entity\PaymentToken as BasePaymentToken;

class PaymentToken extends BasePaymentToken
{
}

```

Add payum przelewy24 gateway configuration

```yaml
payum:
    storages:
        App\Entity\Payment: { doctrine: orm }

    security:
        token_storage:
            App\Entity\PaymentToken: { doctrine: orm }

    gateways:
        przelewy24:
            factory: 'przelewy24'
            sandbox: boolean
            clientId: string
            clientSecret: string
            apiKey: string
            marketplace: boolean
            marketplaceApiKey: string
            marketplaceClientId: string
            marketplaceApiUri: string
            actions:
                invalidateCaptureToken: boolean

```

For marketplace Przelewy24 doesn't have sandbox. 
