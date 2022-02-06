<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

trait GuardTrait
{
    public function validateOrFail($input, array $context = [], string $message = 'Validation errors'): void
    {
        if (! $this instanceof Validation) {
            return;
        }

        $violations = $this->validate($input, $context);
        if (!$violations->isOk()) {
            throw new ValidationException($violations, $message);
        }
    }
}
