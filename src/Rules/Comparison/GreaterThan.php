<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Comparison;

use Attribute;
use BrenoRoosevelt\Validation\Operator;

#[Attribute(Attribute::TARGET_PROPERTY)]
class GreaterThan extends Compare
{
    public function __construct(
        mixed $value,
        ?string $message = null,
        ?int $stopOnFailure = null,
        ?int $priority = null
    ) {
        parent::__construct(
            Operator::GREATER_THAN,
            $value,
            $message,
            $stopOnFailure,
            $priority
        );
    }
}
