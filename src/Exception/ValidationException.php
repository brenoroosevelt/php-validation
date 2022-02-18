<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Exception;

use BrenoRoosevelt\Validation\Error;
use Exception;
use JsonSerializable;
use Phpro\ApiProblem\Http\HttpApiProblem;
use Throwable;

class ValidationException extends Exception implements ValidationExceptionInterface, JsonSerializable
{
    private static ?ValidationExceptionFactoryInterface $userDefinedFactory = null;

    /** @var Error[] */
    private array $errors;

    public function __construct(array $errors, ?string $message = "", int $code = 400, ?Throwable $previous = null)
    {
        $this->errors = array_filter($errors, fn($e) => $e instanceof Error);
        parent::__construct($message ?? '', $code, $previous);
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

    /**
     * Convert to HttpApiProblem
     *
     * @return HttpApiProblem
     */
    public function toApiProblem(): HttpApiProblem
    {
        return new HttpApiProblem($this->getCode(), [
            'type' => HttpApiProblem::TYPE_HTTP_RFC,
            'title' => HttpApiProblem::getTitleForStatusCode($this->getCode()),
            'detail' => $this->message ?? 'Input validation failed',
            'violations' => $this->serializeViolations(),
        ]);
    }

    private function serializeViolations(): array
    {
        $violations = [];
        foreach ($this->errors as $violation) {
            $violationEntry = [
                'propertyPath' => $violation->field(),
                'title' => $violation->message(),
            ];

            $violations[] = $violationEntry;
        }

        return $violations;
    }

    /**
     * Provides an RFC 7807 compliant response
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toApiProblem()->toArray();
    }
}
