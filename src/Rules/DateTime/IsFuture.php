<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\DateTime;

use Attribute;
use BrenoRoosevelt\Validation\Operator;

#[Attribute(Attribute::TARGET_PROPERTY)]
class IsFuture extends DateTimeCompare
{
    public function __construct(
        ?string $message = null,
        ?int $stopOnFailure = null,
        ?int $priority = null
    ) {
        parent::__construct(
            Operator::GREATER_THAN,
            'now',
            $message,
            $stopOnFailure,
            $priority
        );
    }
}
