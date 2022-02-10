<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Tests;

use BrenoRoosevelt\Validation\AbstractRule;
use PHPUnit\Framework\TestCase;

class AbstractValidationTest extends TestCase
{
    /** @test */
    public function shouldProvideDefaultMessage(): void
    {
        $validation = new class extends AbstractRule {
            public function isValid($input, array $context = []): bool {
                return false;
            }
        };

        $this->assertStringContainsString('Constraint violation', $validation->message());
    }

    /** @test */
    public function shouldValidateAccordingAbstractMethod_TRUE(): void
    {
        $validation = new class extends AbstractRule {
            public function isValid($input, array $context = []): bool {
                return true;
            }
        };
        $result = $validation->validate(null);
        $this->assertTrue($result->isOk());
    }

    /** @test */
    public function shouldValidateAccordingAbstractMethod_FALSE(): void
    {
        $validation = new class extends AbstractRule {
            public function isValid($input, array $context = []): bool {
                return false;
            }
        };
        $result = $validation->validate(null);
        $this->assertFalse($result->isOk());
    }
}
