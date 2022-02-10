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
        ValidationExceptionFactoryInterface | ValidationExceptionInterface | string | null $validationException = null
    ): void {
        $result = $rule->validate($input, $context);
        $this->guardResult($result, $validationException);
    }

    /**
     * @throws ValidationExceptionInterface
     */
    protected function guardResult(
        Result $result,
        ValidationExceptionFactoryInterface | ValidationExceptionInterface | string | null $validationException = null
    ): void {
        if ($result->isOk()) {
            return;
        }

        if ($validationException instanceof ValidationExceptionInterface) {
            throw $validationException;
        }

        if ($validationException instanceof ValidationExceptionFactoryInterface) {
            throw $validationException->create($result);
        }

        $exceptionMessage = $validationException;
        if (ValidationException::hasFactory()) {
            throw ValidationException::getFactory()->create($result, $exceptionMessage);
        }

        throw new ValidationException($result->getErrors(), $exceptionMessage);
    }
}
