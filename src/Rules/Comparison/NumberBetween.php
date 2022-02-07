<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Comparison;

use Attribute;
use BrenoRoosevelt\Validation\AbstractValidation;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NumberBetween extends AbstractValidation
{
    const MESSAGE = 'The value should be between `%s` and `%s` (%s including the boundaries)';

    public function __construct(
        private int|float $min,
        private int|float $max,
        private $boundaries = true,
        ?string $message = null
    ) {
        $this->message =
            $message ??
            sprintf(
                self::MESSAGE,
                $this->min,
                $this->max,
                !$this->boundaries ? 'not' : ''
            );
        parent::__construct($message);
    }

    protected function evaluate($input, array $context = []): bool
    {
        if ($this->boundaries) {
            return $input >= $this->min && $input <= $this->max;
        }

        return $input > $this->min && $input < $this->max;
    }
}
