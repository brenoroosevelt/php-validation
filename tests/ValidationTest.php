<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Tests;

use BrenoRoosevelt\Validation\Rules\NotEmptyString;
use BrenoRoosevelt\Validation\RuleSet;
use BrenoRoosevelt\Validation\Validator;
use PHPUnit\Framework\TestCase;

class ValidationTest extends TestCase
{
    /** @test */
    public function validatesAll(): void
    {
            Validator::new()
                ->field('name', new NotEmptyString)
                ->validate(['name' => '']);


        $this->assertTrue(RuleSet::new()->notNull()->validate(1)->isOk());
    }
}
