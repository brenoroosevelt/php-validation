<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Exception;

use BrenoRoosevelt\Validation\Result;

final class ValidationExceptionFactory implements ValidationExceptionFactoryInterface
{
    private static ?ValidationExceptionFactoryInterface $userDefinedFactory = null;

    public function __construct(private ValidationExceptionInterface | string | null $exception = null)
    {
    }

    public static function setDefault(ValidationExceptionFactoryInterface $factory): void
    {
        self::$userDefinedFactory = $factory;
    }

    /** @inheritDoc */
    public function create(Result $result): ValidationExceptionInterface
    {
        return
            self::$userDefinedFactory instanceof ValidationExceptionFactoryInterface ?
                self::$userDefinedFactory->create($result) :
                $this->defaultException($result);
    }

    private function defaultException(Result $result): ValidationExceptionInterface
    {
        return
            $this->exception instanceof ValidationExceptionInterface ?
                $this->exception :
                new ValidationException(
                    $result->getErrors(),
                    is_string($this->exception) ? $this->exception : ''
                );
    }
}
