<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Number;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NumberBetween extends AbstractRule
{
    const MESSAGE = 'The value should be between `%s` and `%s` (%sincluding the boundaries)';

    public function __construct(
        private int|float $min,
        private int|float $max,
        private $boundaries = true,
        ?string $message = null
    ) {
        $message =
            $message ??
            sprintf(
                self::MESSAGE,
                $this->min,
                $this->max,
                !$this->boundaries ? 'not ' : ''
            );
        parent::__construct($message);
    }

    public function isValid($input, array $context = []): bool
    {
        if ($this->boundaries) {
            return $input >= $this->min && $input <= $this->max;
        }

        return $input > $this->min && $input < $this->max;
    }
}
