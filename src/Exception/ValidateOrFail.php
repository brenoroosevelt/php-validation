<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Exception;

trait ValidateOrFail
{
    use Guard;

    /**
     * @throws ValidationExceptionInterface
     * @throws ValidationException
     */
    public function validateOrFail(
        mixed $input,
        array $context = [],
        ?ValidationExceptionInterface $validationException = null
    ): void {
        $this->guardRule($this, $input, $context, $validationException);
    }
}
