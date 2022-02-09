<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Comparison;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Equal extends AbstractRule
{
    const MESSAGE = 'The value should be equals to `%s`';

    public function __construct(private mixed $value, ?string $message = null)
    {
        $message = $message ?? sprintf(self::MESSAGE, $this->value);
        parent::__construct($message);
    }

    public function isValid($input, array $context = []): bool
    {
        return $input == $this->value;
    }
}
