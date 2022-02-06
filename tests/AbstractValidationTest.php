<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Tests;

use BrenoRoosevelt\Validation\AbstractValidation;
use PHPUnit\Framework\TestCase;

class AbstractValidationTest extends TestCase
{
    /** @test */
    public function shouldProvideDefaultMessage(): void
    {
            $validation = new class extends AbstractValidation {
            protected function isValid($input, array $context = []): bool {
                return false;
            }
        };
        $result = $validation->validate(null);
        $this->assertStringContainsString('Constraint violation', $result->getErrors()[0]);
    }

    /** @test */
    public function shouldUseProvidedMessage(): void
    {
        $message = 'My Error';
        $validation = new class($message) extends AbstractValidation {
            protected function isValid($input, array $context = []): bool {
                return false;
            }
        };
        $result = $validation->validate(null);
        $this->assertEquals($message, $result->getErrors()[0]);
    }

    /** @test */
    public function shouldValidateAccordingAbstractMethod_TRUE(): void
    {
        $validation = new class extends AbstractValidation {
            protected function isValid($input, array $context = []): bool {
                return true;
            }
        };
        $result = $validation->validate(null);
        $this->assertTrue($result->isOk());
    }

    /** @test */
    public function shouldValidateAccordingAbstractMethod_FALSE(): void
    {
        $validation = new class extends AbstractValidation {
            protected function isValid($input, array $context = []): bool {
                return false;
            }
        };
        $result = $validation->validate(null);
        $this->assertFalse($result->isOk());
    }
}
