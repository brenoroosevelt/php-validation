<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Exception;

use BrenoRoosevelt\Validation\Result;
use BrenoRoosevelt\Validation\Rule;
use BrenoRoosevelt\Validation\ValidationResultSet;

trait Guard
{
    /**
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
     */
    protected function guardResult(
        Result | ValidationResultSet $guardResult,
        ?ValidationExceptionInterface $validationException = null
    ): void {
        if ($guardResult->isOk()) {
            return;
        }

        $exception =
            $validationException instanceof ValidationExceptionInterface ?
                $validationException :
                new ValidationException;

        $results = $guardResult instanceof Result ? [$guardResult] : $guardResult->validationResults();
        foreach ($results as $result) {
            foreach ($result->getErrors() as $error) {
                $exception->addError($error, $result->getField());
            }
        }

        throw $exception;
    }
}
