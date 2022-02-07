<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractValidation;
use Traversable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class CountExactly extends AbstractValidation
{
    const MESSAGE = 'Expected count is: %s';

    public function __construct(private int $count, string $message = null)
    {
        parent::__construct($message ?? sprintf(self::MESSAGE, $this->count));
    }

    protected function evaluate($input, array $context = []): bool
    {
        if (is_countable($input)) {
            return count($input) === $this->count;
        }

        if ($input instanceof Traversable) {
            return iterator_count($input) === $this->count;
        }

        if (is_iterable($input)) {
            $count = 0;
            foreach ($input as $v) {
                $count++;
            }

            return $count === $this->count;
        }

        return false;
    }
}
