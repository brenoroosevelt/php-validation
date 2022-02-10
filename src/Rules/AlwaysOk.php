<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use BrenoRoosevelt\Validation\ErrorReporting;
use BrenoRoosevelt\Validation\Result;
use BrenoRoosevelt\Validation\Rule;

final class AlwaysOk implements Rule
{
    public function validate(mixed $input, array $context = []): Result
    {
        return ErrorReporting::success();
    }
}
