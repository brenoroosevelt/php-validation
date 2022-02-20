<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Contracts\Error;
use BrenoRoosevelt\Validation\Contracts\Result;
use BrenoRoosevelt\Validation\Contracts\Rule;
use BrenoRoosevelt\Validation\Contracts\Stoppable;
use BrenoRoosevelt\Validation\Exception\ParseErrors;
use BrenoRoosevelt\Validation\Exception\Guard;
use BrenoRoosevelt\Validation\Exception\ValidationExceptionFactoryInterface;
use BrenoRoosevelt\Validation\Exception\ValidationExceptionInterface;

class ErrorReporting implements Result
{
    use Guard;

    use ParseErrors {
        errorsAsArray as toArray;
    }

    /** @var Error[] */
    private array $errors = [];
    private int $stopSign = Stoppable::DONT_STOP;

    final public function __construct(Error | Result ...$errors)
    {
        foreach ($errors as $errorOrResult) {
            array_push(
                $this->errors,
                ...($errorOrResult instanceof Result ? $errorOrResult->getErrors() : [$errorOrResult])
            );
        }
    }

    public static function success(): self
    {
        return new self;
    }

    public function add(Error | Result ...$errors): self
    {
        return new self(...$this->errors, ...$errors);
    }

    public function addError(string $message, ?string $field = null, ?Rule $rule = null): self
    {
        return $this->add(new AnError($message, $field, $rule));
    }

    /** @inheritDoc */
    public function isOk(): bool
    {
        return empty($this->errors);
    }

    /** @inheritDoc */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function stopSign(): int
    {
        return $this->stopSign;
    }

    public function withStopSign(int $stopSign): self
    {
        $instance = clone $this;
        $instance->stopSign = $stopSign;
        return $instance;
    }

    /** @throws ValidationExceptionInterface */
    public function guard(
        ValidationExceptionFactoryInterface | ValidationExceptionInterface | string | null  $validationException = null
    ): void {
        $this->guardResult($this, $validationException);
    }
}
