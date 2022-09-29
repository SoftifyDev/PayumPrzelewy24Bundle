<?php

namespace Softify\PayumPrzelewy24Bundle\Validator\Constraints;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\Mapping\ClassMetadata;
use Payum\Core\PayumBuilder;
use Softify\PayumPrzelewy24Bundle\Dto\Marketplace\AffiliatesResponseDto;
use Softify\PayumPrzelewy24Bundle\Request\VerifyMerchantIdRequest;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class MerchantIdValidator extends ConstraintValidator
{
    private ManagerRegistry $registry;
    private PayumBuilder $payumBuilder;

    public function __construct(ManagerRegistry $registry, PayumBuilder $payumBuilder)
    {
        $this->registry = $registry;
        $this->payumBuilder = $payumBuilder;
    }

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof MerchantId) {
            throw new UnexpectedTypeException($constraint, MerchantId::class);
        }

        $em = $this->registry->getManagerForClass(\get_class($value));

        if (!$em) {
            throw new ConstraintDefinitionException(sprintf('Unable to find the object manager associated with an entity of class "%s".', get_debug_type($value)));
        }

        $class = $em->getClassMetadata(\get_class($value));

        $merchantId = $this->getFieldValue($constraint->merchantIdField, $class, $value);
        if (empty($merchantId)) {
            return;
        }

        $nip = $this->getFieldValue($constraint->nipField, $class, $value);
        $regon = $constraint->regonField ? $this->getFieldValue($constraint->regonField, $class, $value) : null;

        $verifyMerchantIdRequest = new VerifyMerchantIdRequest($merchantId, $nip, $regon);
        $this->payumBuilder->getPayum()->getGateway('przelewy24')->execute($verifyMerchantIdRequest);

        $response = $verifyMerchantIdRequest->getAffiliatesResponseDto();
        if ($response instanceof AffiliatesResponseDto) {
            if (count($response->getData()) === 0) {
                $this->context->buildViolation($constraint->messageEmptyResponse)
                    ->setTranslationDomain('validators')
                    ->setCode('3dc33b7c-c2e4-4c31-b0a0-14d4605652a2')
                    ->atPath($constraint->merchantIdField)
                    ->addViolation();
            } else {
                if ($response->getData()[0]->getNip() !== $nip) {
                    $this->context->buildViolation($constraint->messageDifferentNip)
                        ->setTranslationDomain('validators')
                        ->setCode('240fca01-72ab-4a11-97a7-cdb8f39959ca')
                        ->atPath($constraint->nipField)
                        ->addViolation();
                }
                if ($regon && $response->getData()[0]->getRegon() !== $regon) {
                    $this->context->buildViolation($constraint->messageDifferentNip)
                        ->setTranslationDomain('validators')
                        ->setCode('bb2d7028-a6f3-413e-acce-c2d585bcd84d')
                        ->atPath($constraint->regonField)
                        ->addViolation();
                }
            }
        } else {
            $this->context->buildViolation($constraint->messageError)
                ->setTranslationDomain('validators')
                ->setCode('03bddc6e-5716-4c54-9273-dd60d3822576')
                ->atPath($constraint->merchantIdField)
                ->addViolation();
        }
    }

    protected function getFieldValue(string $fieldName, ClassMetadata $class, object $entity)
    {
        if (!$class->hasField($fieldName) && !$class->hasAssociation($fieldName)) {
            throw new ConstraintDefinitionException(sprintf('The field "%s" is not mapped by Doctrine, so it cannot be validated for uniqueness.', $fieldName));
        }
        return $class->reflFields[$fieldName]->getValue($entity);
    }
}
