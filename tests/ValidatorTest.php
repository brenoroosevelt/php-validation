<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Tests;

use BrenoRoosevelt\Validation\Exception\ValidationExceptionInterface;
use BrenoRoosevelt\Validation\Rules\AllowsEmpty;
use BrenoRoosevelt\Validation\Rules\AllowsNull;
use BrenoRoosevelt\Validation\Rules\Email;
use BrenoRoosevelt\Validation\Rules\Required;
use BrenoRoosevelt\Validation\RuleSet;
use BrenoRoosevelt\Validation\Validator;
use Hoa\Compiler\Llk\Rule\Rule;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    /** @test */
    public function validatesNotRequiredRequired(): void
    {
        $validator = Validator::new()->field('name', new Email);
        $result = $validator->validate([]);
        $this->assertTrue($result->isOk());
    }

    /** @test */
    public function validatesNotRequired(): void
    {
        $this->assertFalse(false);
    }
}
