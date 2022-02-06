<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Tests;

use BrenoRoosevelt\Validation\Rules\AlwaysOk;
use PHPUnit\Framework\TestCase;

class AlwaysOkTest extends TestCase
{
    /** @test */
    public function validates(): void
    {
        $result = (new AlwaysOk)->validate(null);
        $this->assertTrue($result->isOk());
    }
}
