<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Exception;

use BrenoRoosevelt\Validation\Result;
use BrenoRoosevelt\Validation\ResultByField;
use BrenoRoosevelt\Validation\Rule;

trait Guard
{
    /**
     * @throws ValidationException
     * @throws ValidationExceptionInterface
     */
    protected function guardRule(
        Rule $rule,
        mixed $input,
        array $context = [],
        ?ValidationExceptionInterface $validationException = null
    ): void {
        $result = $rule->validate($input, $context);
        $this->guardResult($result, $validationException);
    }

    /**
     * @throws ValidationExceptionInterface
     * @throws ValidationException
     */
    protected function guardResult(Result $result, ?ValidationExceptionInterface $validationException = null): void
    {
        if ($result->isOk()) {
            return;
        }

        $exception =
            $validationException instanceof ValidationExceptionInterface ?
                $validationException :
                new ValidationException();

        $field = $result instanceof ResultByField ? $result->getField() : null;
        foreach ($result->getErrors() as $error) {
            $exception->addError($error, $field);
        }

        throw $exception;
    }
}
