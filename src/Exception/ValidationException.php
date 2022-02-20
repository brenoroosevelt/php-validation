<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Exception;

use BrenoRoosevelt\Validation\Contracts\Error;
use Exception;
use JsonSerializable;
use Throwable;

class ValidationException extends Exception implements ValidationExceptionInterface, JsonSerializable
{
    use ParseErrorsTrait;

    private static ?ValidationExceptionFactoryInterface $userDefinedFactory = null;

    /** @var Error[] */
    private array $errors;

    public function __construct(array $errors, ?string $message = "", int $code = 400, ?Throwable $previous = null)
    {
        $this->errors = array_filter($errors, fn($e) => $e instanceof Error);
        parent::__construct($message ?? 'Input validation failed', $code, $previous);
    }

    /** @inheritDoc */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public static function setFactory(?ValidationExceptionFactoryInterface $factory): void
    {
        self::$userDefinedFactory = $factory;
    }

    public static function hasFactory(): bool
    {
        return self::$userDefinedFactory instanceof ValidationExceptionFactoryInterface;
    }

    public static function getFactory(): ?ValidationExceptionFactoryInterface
    {
        return self::$userDefinedFactory;
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'code' => $this->getCode(),
            'violations' => $this->errorsAsArray(),
        ];
    }

    public function toString(): string
    {
        return sprintf('%s:%s%s', $this->message, PHP_EOL, $this->errorsAsString());
    }

    public function __toString()
    {
        return $this->toString();
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
