<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Tests\Rules;

use ArrayObject;
use BrenoRoosevelt\Validation\Rules\CountAtLeast;
use BrenoRoosevelt\Validation\Tests\RuleTester;
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
                new CountAtLeast(1),
                []
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
                new CountAtLeast(1),
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
