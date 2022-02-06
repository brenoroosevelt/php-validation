<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Tests;

use BrenoRoosevelt\Validation\AlwaysOk;
use BrenoRoosevelt\Validation\NotRequired;
use PHPUnit\Framework\TestCase;

class NotRequiredTestTest extends TestCase
{
    /** @test */
    public function validates(): void
    {
        $result = (new NotRequired)->validate(null);
        $this->assertTrue($result->isOk());
    }
}
