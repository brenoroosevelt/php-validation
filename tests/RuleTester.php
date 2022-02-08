<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Tests;

use BrenoRoosevelt\Validation\Rule;
use PHPUnit\Framework\Constraint\StringContains;
use PHPUnit\Framework\TestCase;

abstract class RuleTester extends TestCase
{
    abstract public function ruleClass(): string;
    abstract public function invalidInputProvider(): array;
    abstract public function validInputProvider(): array;

    /**
     * @param Rule $rule
     * @param mixed $input
     * @param array $context
     * @param string|null $expectedError
     * @return void
     * @dataProvider invalidInputProvider
     */
    public function testInvalidInputs(
        Rule $rule,
        mixed $input,
        array $context = [],
        ?string $expectedError = null
    ): void {
        $this->assertInstanceOf($this->ruleClass(), $rule);
        $result = $rule->validate($input, $context);
        $this->assertFalse($result->isOk());
        $this->assertNotEmpty($result->getErrors());
        if (null !== $expectedError) {
            $this->assertErrorMessagesContain($expectedError, $result->getErrors());
        }
    }

    /**
     * @param Rule $rule
     * @param mixed $input
     * @param array $context
     * @return void
     * @dataProvider validInputProvider
     */
    public function testValidInputs(Rule $rule, mixed $input, array $context = []): void
    {
        $this->assertInstanceOf($this->ruleClass(), $rule);
        $result = $rule->validate($input, $context);
        $this->assertTrue($result->isOk());
        $this->assertEmpty($result->getErrors());
    }

    protected function assertErrorMessagesContain(string $text, array $errors): void
    {
        $contain = false;
        $constraint = new StringContains($text, true);
        foreach ($errors as $error) {
            if (true === $constraint->evaluate($error, '', true)) {
                $contain = true;
                break;
            }
        }

        $this->assertTrue($contain, 'No error messages contain: ' . $text);
    }
}
