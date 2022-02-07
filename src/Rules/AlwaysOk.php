<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use BrenoRoosevelt\Validation\Result;
use BrenoRoosevelt\Validation\Validation;
use BrenoRoosevelt\Validation\ValidationResult;

final class AlwaysOk implements Validation
{
    private static ?self $instance = null;

    public static function instance(): self
    {
        return self::$instance ?? self::$instance = new self;
    }

    public function validate(mixed $input, array $context = []): Result
    {
        return ValidationResult::everythingIsOk();
    }
}
