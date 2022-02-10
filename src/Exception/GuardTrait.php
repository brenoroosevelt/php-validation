<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Exception;

use BrenoRoosevelt\Validation\Result;
use BrenoRoosevelt\Validation\Rule;

trait GuardTrait
{
    /**
     * @throws ValidationExceptionInterface
     */
    protected function guardRule(
        Rule $rule,
        mixed $input,
        array $context = [],
        ValidationExceptionInterface | string | null $validationException = null
    ): void {
        $result = $rule->validate($input, $context);
        $this->guardResult($result, $validationException);
    }

    /**
     * @throws ValidationExceptionInterface
     */
    protected function guardResult(
        Result $result,
        ValidationExceptionInterface | string | null $validationException = null
    ): void {
        if ($result->isOk()) {
            return;
        }

        $exception = $this->createValidationException($validationException);
        foreach ($result->getErrors() as $error) {
            $exception->addError($error->message(), $error->field());
        }

        throw $exception;
    }

    private function createValidationException(
        ValidationExceptionInterface | string | null $validationException = null
    ): ValidationExceptionInterface {
        return
            $validationException instanceof ValidationExceptionInterface ?
                $validationException :
                new ValidationException(is_string($validationException) ? $validationException : '');
    }
}
