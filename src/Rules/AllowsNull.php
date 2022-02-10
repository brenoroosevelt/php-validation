<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\ErrorReporting;
use BrenoRoosevelt\Validation\Result;
use BrenoRoosevelt\Validation\Rule;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class AllowsNull implements Rule
{
    public function validate(mixed $input, array $context = []): Result
    {
        return ErrorReporting::success();
    }
}
