<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Tests;

use BrenoRoosevelt\Validation\GuardTrait;
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
            use GuardTrait;
            public function validate($input, array $context = []): Result {
                return (new ValidationResult)->add('error');
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
                use GuardTrait;
            };
            $validation->validateOrFail(null);
        } catch (\Throwable $exception) {
            $this->assertTrue(false);
        }
        $this->assertTrue(true);
    }
}
