<?php

declare(strict_types=1);

namespace Softify\PayumPrzelewy24Bundle\Exception;

use Payum\Core\Exception\Http\HttpException;
use Softify\PayumPrzelewy24Bundle\Dto\ErrorResponseDto;

final class PaymentException extends HttpException
{
    public const LABEL = 'PaymentException';

    public static function newInstanceFromErrorResponse(ErrorResponseDto $errorResponse): self
    {
        $parts = [self::LABEL];

        if ($errorResponse->getCode()) {
            $parts[] = sprintf('[status code] %s' , $errorResponse->getCode());
        }

        if ($errorResponse->getError()) {
            $parts[] = sprintf('[reason literal] %s' , $errorResponse->getError());
        }

        $message = implode(\PHP_EOL, $parts);

        return new PaymentException($message, $errorResponse->getCode());
    }
}
