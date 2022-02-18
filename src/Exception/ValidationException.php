<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Exception;

use BrenoRoosevelt\Validation\Error;
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
        $message = $message ?? 'Input validation failed' . PHP_EOL . $this->errorsAsString();
        parent::__construct($message, $code, $previous);
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
            'message' => $this->message ?? 'Input validation failed',
            'code' => $this->getCode(),
            'violations' => $this->errorsAsArray(),
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
