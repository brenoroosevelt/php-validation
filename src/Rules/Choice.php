<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Choice extends AbstractValidation
{
    const MESSAGE = 'Invalid choice, accepted values are: %s';

    public function __construct(private array $list, private bool $strict = true, string $message = null)
    {
        parent::__construct($message ?? sprintf(self::MESSAGE, implode(', ', $this->list)));
    }

    protected function isValid($input, array $context = []): bool
    {
        return in_array($input, $this->list, $this->strict);
    }
}
