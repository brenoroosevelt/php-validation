<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Tests\Rules;

use ArrayObject;
use BrenoRoosevelt\Validation\Rules\CountAtLeast;
use BrenoRoosevelt\Validation\Tests\RuleTester;
use DateTimeImmutable;
use Generator;
use stdClass;

class CountAtLeastTest extends RuleTester
{
    public function ruleClass(): string
    {
        return CountAtLeast::class;
    }

    public function invalidInputProvider(): array
    {
        return [
            'case_0' => [
                new CountAtLeast(1, 'MY_ERROR'),
                [],
                [],
                'MY_ERROR'
            ],
            'case_1' => [
                new CountAtLeast(1, null),
                [],
                [],
                'Expected count is at least'
            ],
            'case_2' => [
                new CountAtLeast(5),
                [1, 2, 3, 4]
            ],
            'case_3' => [
                new CountAtLeast(0),
                null
            ],
            'case_4' => [
                new CountAtLeast(0),
                new stdClass()
            ],
            'case_5' => [
                new CountAtLeast(0),
                0
            ],
            'case_6' => [
                new CountAtLeast(2),
                new ArrayObject([1])
            ],
            'case_7' => [
                new CountAtLeast(4),
                (function(): Generator {
                    yield 1;
                    yield 2;
                    yield 3;
                })()
            ],
            'case_8' => [
                new CountAtLeast(2),
                '123'
            ],
            'case_9' => [
                new CountAtLeast(1),
                99.99
            ],
            'case_10' => [
                new CountAtLeast(1),
                true
            ],
            'case_11' => [
                new CountAtLeast(0),
                false
            ],
            'case_12' => [
                new CountAtLeast(0),
                new DateTimeImmutable()
            ]
        ];
    }

    public function validInputProvider(): array
    {
        return [
            'case_0' => [
                new CountAtLeast(0),
                []
            ],
            'case_1' => [
                new CountAtLeast(1),
                [1]
            ],
            'case_3' => [
                new CountAtLeast(3),
                new ArrayObject([1, 2, 3])
            ],
            'case_4' => [
                new CountAtLeast(0),
                new ArrayObject()
            ],
            'case_5' => [
                new CountAtLeast(3),
                (function(): Generator {
                    yield 1;
                    yield 2;
                    yield 3;
                })()
            ]
        ];
    }
}
