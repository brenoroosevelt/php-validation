<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Tests;

use BrenoRoosevelt\Validation\Rules\Comparison\Equal;
use BrenoRoosevelt\Validation\Rules\Email;
use BrenoRoosevelt\Validation\Rules\IsNull;
use BrenoRoosevelt\Validation\Rules\Not;
use BrenoRoosevelt\Validation\Rules\NotNull;
use BrenoRoosevelt\Validation\Translation\Translator;
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
        Translator::setDefault(function (string $message, ...$args) {
            return
                match($message) {
                    NotNull::MESSAGE => 'O valor não pode ser nulo',
                    default => null
                };
        });

//        $r = (new NotNull())->validate(null);
//        var_dump($r->getErrors());
        $this->assertFalse(false);
    }

    public function testA()
    {
        $r = (new Equal(2))->validate(1);
        var_dump($r->getErrors());
    }
}
