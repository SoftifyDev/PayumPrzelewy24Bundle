<?php

namespace Softify\PayumPrzelewy24Bundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 */
class MerchantId extends Constraint
{
    public string $messageError = 'error_in_response';
    public string $messageNotFoundResponse = 'missing_merchant_id';
    public string $messageNotVerified = 'not_verified';
    public string $messageDifferentNip = 'different_nip';
    public string $messageDifferentRegon = 'different_regon';
    public string $merchantIdField;
    public string $nipField;
    public ?string $regonField;
    public ?string $expression;

    public function __construct(
        $options = null,
        array $groups = null,
        $payload = null
    ) {
        $this->merchantIdField = $options['merchantIdField'] ?? null;
        $this->nipField = $options['nipField'] ?? null;
        $this->regonField = $options['regonField'] ?? null;
        $this->expression = $options['expression'] ?? null;
        parent::__construct($options, $groups, $payload);
    }

    public function getRequiredOptions(): array
    {
        return ['merchantIdField', 'nipField'];
    }

    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
