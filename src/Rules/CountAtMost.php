<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use Traversable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class CountAtMost extends AbstractRule
{
    const MESSAGE = 'Expected count is at most: %s';

    public function __construct(private int $count, string $message = null)
    {
        parent::__construct($message ?? sprintf(self::MESSAGE, $this->count));
    }

    protected function evaluate($input, array $context = []): bool
    {
        if (is_countable($input)) {
            return count($input) <= $this->count;
        }

        if (is_iterable($input)) {
            $count = 0;
            foreach ($input as $v) {
                $count++;
                if ($count > $this->count) {
                    return false;
                }
            }

            return $count <= $this->count;
        }

        return false;
    }
}
