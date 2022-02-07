<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\Result;
use BrenoRoosevelt\Validation\Validation;
use BrenoRoosevelt\Validation\ValidationResult;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class NotRequired implements Validation
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
