<?php

namespace Softify\PayumPrzelewy24Bundle\Factory;

use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayFactory;
use Softify\PayumPrzelewy24Bundle\Api\Api;

class Przelewy24GatewayFactory extends GatewayFactory
{
    protected function populateConfig(ArrayObject $config): void
    {
        if (!$config['payum.api']) {
            $config['payum.default_options'] = [
                'clientId' => null,
                'clientSecret' => null,
                'apiKey' => null,
                'sandbox' => true
            ];

            $config->defaults($config['payum.default_options']);
            $config['payum.required_options'] = ['clientId', 'clientSecret', 'apiKey'];

            $config['payum.api'] = static function (ArrayObject $config) {
                $config->validateNotEmpty($config['payum.required_options']);
                return new Api(
                    [
                        'clientId' => $config['clientId'],
                        'clientSecret' => $config['clientSecret'],
                        'apiKey' => $config['apiKey'],
                        'sandbox' => $config['sandbox']
                    ]
                );
            };
        }
    }
}
