<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Comparison;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;

#[Attribute(Attribute::TARGET_PROPERTY)]
class EqualsToAnother extends AbstractRule
{
    const MESSAGE = 'The value should be equals to `%s`';

    public function __construct(private mixed $other, ?string $message = null)
    {
        $this->message = $message ?? sprintf(self::MESSAGE, $this->other);
        parent::__construct($message);
    }

    public function isValid($input, array $context = []): bool
    {
        return array_key_exists($this->other, $context) && $input == $context[$this->other];
    }
}
