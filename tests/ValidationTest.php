<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Tests;

use BrenoRoosevelt\Validation\RuleSet;
use PHPUnit\Framework\TestCase;

class ValidationTest extends TestCase
{
    /** @test */
    public function validatesAll(): void
    {
        $this->assertTrue(RuleSet::new()->notNull()->validate(1)->isOk());
    }
}
