<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Tests;

use BrenoRoosevelt\Validation\Rules\Brazilian\DigitoVerificador;
use BrenoRoosevelt\Validation\Rules\Email;
use BrenoRoosevelt\Validation\Rules\Generic;
use BrenoRoosevelt\Validation\Rules\NotRequired;
use BrenoRoosevelt\Validation\Rules\Type\IsArray;
use BrenoRoosevelt\Validation\RuleSet;
use BrenoRoosevelt\Validation\ValidationException;
use BrenoRoosevelt\Validation\Validator;
use Hoa\Compiler\Llk\Rule\Rule;
use PHPUnit\Framework\TestCase;

class ValidationTest extends TestCase
{
    /** @test */
    public function validatesAll(): void
    {
        $this->assertTrue(true);

        RuleSet::forField('email')
            ->check(fn() => false, 'O valor deve ser algo');
        
        try {
            RuleSet::forField('name')
                ->add(new Email())
                //->setAllowsNull()
                ->equal(1, 'iaguaa')
                ->validateOrFail(null, []);

        } catch (ValidationException  $exception) {
            var_dump($exception->getMessage());
        }

//        Validator::new()
//            ->field('name', RuleSet::new()->equal(10)->setAllowsNull())
//            ->validateOrFail(['name' => 15]);
    }
}
