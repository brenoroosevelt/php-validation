<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Comparison;

use Attribute;
use BrenoRoosevelt\Validation\AbstractValidation;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Equal extends AbstractValidation
{
    const MESSAGE = 'The value should be equals to `%s`';

    public function __construct(private mixed $value, ?string $message = null)
    {
        $this->message = $message ?? sprintf(self::MESSAGE, $this->value);
        parent::__construct($message);
    }

    protected function evaluate($input, array $context = []): bool
    {
        return $input == $this->value;
    }
}
