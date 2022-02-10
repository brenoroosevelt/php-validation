<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Exception;

use BrenoRoosevelt\Validation\Rule;

trait ValidateOrFailTrait
{
    use GuardTrait;

    /**
     * @throws ValidationExceptionInterface
     */
    public function validateOrFail(
        mixed $input,
        array $context = [],
        ValidationExceptionInterface | string | null $validationException = null
    ): void {
        if ($this instanceof Rule) {
            $this->guardRule($this, $input, $context, $validationException);
        }
    }
}
