<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Tests;

use BrenoRoosevelt\Validation\GuardForValidation;
use BrenoRoosevelt\Validation\Result;
use BrenoRoosevelt\Validation\Validation;
use BrenoRoosevelt\Validation\ValidationException;
use BrenoRoosevelt\Validation\ValidationResult;
use PHPUnit\Framework\TestCase;

class GuardTraiTest extends TestCase
{
    /** @test */
    public function shouldThrowValidationErrors(): void
    {
        $validation = new class implements Validation {
            use GuardForValidation;
            public function validate(mixed $input, array $context = []): Result {
                return (new ValidationResult)->error('error');
            }
        };

        $this->expectException(ValidationException::class);
        $validation->validateOrFail(null);
    }

    /** @test */
    public function shouldNotThrowValidationErrorsWhenIsNotValidation(): void
    {
        try {
            $validation = new class {
                use GuardForValidation;
            };
            $validation->validateOrFail(null);
        } catch (\Throwable $exception) {
            $this->assertTrue(false);
        }
        $this->assertTrue(true);
    }
}
