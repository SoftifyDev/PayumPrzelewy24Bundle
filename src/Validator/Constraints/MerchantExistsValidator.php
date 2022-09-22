<?php

namespace Softify\PayumPrzelewy24Bundle\Validator\Constraints;

use Payum\Core\Payum;
use Softify\PayumPrzelewy24Bundle\Dto\Marketplace\MerchantExistsResponseDto;
use Softify\PayumPrzelewy24Bundle\Dto\Marketplace\MerchantRegisterDto;
use Softify\PayumPrzelewy24Bundle\Request\MerchantExistsRequest;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class MerchantExistsValidator extends ConstraintValidator
{
    private Payum $payum;

    public function __construct(Payum $payum)
    {
        $this->payum = $payum;
    }

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof MerchantExists) {
            throw new UnexpectedTypeException($constraint, MerchantExists::class);
        }

        if (!$value instanceof MerchantRegisterDto) {
            throw new UnexpectedTypeException($constraint, MerchantRegisterDto::class);
        }

        $request = null;
        if ($value->getNip()) {
            $request = MerchantExistsRequest::createWithNip($value->getNip());
        } elseif ($value->getPesel()) {
            $request = MerchantExistsRequest::createWithPesel($value->getPesel());
        }

        if ($request) {
            $this->payum->getGateway('przelewy24')->execute($request);
            if (!$request->getMerchantExistsResponseDto() instanceof MerchantExistsResponseDto) {
                $this->context->buildViolation($constraint->message)
                    ->setTranslationDomain('validators')
                    ->setCode('75fb2329-7326-41b7-aa0d-c98de23775e4')
                    ->atPath($request->isNipType() ? MerchantExistsRequest::NIP : MerchantExistsRequest::PESEL)
                    ->addViolation();
            }
        }
    }
}
