<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Comparison;

use Attribute;
use BrenoRoosevelt\Validation\Operator;
use BrenoRoosevelt\Validation\Translation\Translator;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NotExactly extends Compare
{
    const MESSAGE = 'Value should not be identical to `%s`';

    public function __construct(
        mixed $value,
        ?string $message = null,
        ?int $stopOnFailure = null,
        ?int $priority = null
    ) {
        parent::__construct(
            Operator::NOT_EXACTLY,
            $value,
            $message,
            $stopOnFailure,
            $priority
        );
    }

    public function translatedMessage(): ?string
    {
        return Translator::translate(self::MESSAGE, $this->value);
    }
}
