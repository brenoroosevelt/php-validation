<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

trait GuardForValidation
{
    public function validateOrFail($input, array $context = [], ?string $message = null): void
    {
        if (! $this instanceof Rule) {
            return;
        }

        $violations = $this->validate($input, $context);
        if (!$violations->isOk()) {
            throw new ValidationException($violations, $message);
        }
    }
}
