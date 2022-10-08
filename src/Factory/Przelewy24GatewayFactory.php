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
                'marketplace' => false,
                'marketplaceApiKey' => null,
                'marketplaceClientId' => null,
                'marketplaceApiUri' => null,
                'actions' => [
                    'invalidateCaptureToken' => true
                ]
            ];

            $config->defaults($config['payum.default_options']);
            $config['payum.required_options'] = ['clientId', 'clientSecret', 'apiKey'];
            $config['payum.marketplace_required_options'] = ['marketplaceApiKey', 'marketplaceClientId'];

            $config['payum.api'] = static function (ArrayObject $config) {
                if ($config['marketplace']) {
                    $config->validateNotEmpty($config['payum.marketplace_required_options']);
                } else {
                    $config->validateNotEmpty($config['payum.required_options']);
                }
                return new Api(
                    [
                        'clientId' => $config['clientId'] ? (int)$config['clientId'] : null,
                        'clientSecret' => $config['clientSecret'],
                        'apiKey' => $config['apiKey'],
                        'sandbox' => $config['sandbox'],
                        'marketplace' => $config['marketplace'],
                        'marketplaceApiKey' => $config['marketplaceApiKey'],
                        'marketplaceClientId' => $config['marketplaceClientId'] ? (int)$config['marketplaceClientId'] : null,
                        'marketplaceApiUri' => $config['marketplaceApiUri'],
                        'actions' => $config['actions'],
                    ]
                );
            };
        }
    }
}
