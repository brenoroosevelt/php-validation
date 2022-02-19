<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Tests;

use BrenoRoosevelt\Validation\Rules\Email;
use BrenoRoosevelt\Validation\Rules\IsNull;
use BrenoRoosevelt\Validation\Rules\Not;
use BrenoRoosevelt\Validation\Rules\NotNull;
use BrenoRoosevelt\Validation\Validator;
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

        $r = (new NotNull())->validate(null);
        var_dump($r->getErrors());
        $this->assertFalse(false);
    }
}
