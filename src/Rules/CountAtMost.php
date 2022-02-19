<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use BrenoRoosevelt\Validation\StopSign;
use Traversable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class CountAtMost extends AbstractRule
{
    const MESSAGE = 'Expected count is at most: %s';

    public function __construct(
        private int $size,
        ?string $message = null,
        int $stopOnFailure = StopSign::DONT_STOP
    ) {
        $message = $message ?? sprintf(self::MESSAGE, $this->size);
        parent::__construct($message, $stopOnFailure);
    }
//    public function __construct(private int $count, string $message = null)
//    {
//        parent::__construct($message ?? sprintf(self::MESSAGE, $this->count));
//    }

    public function isValid($input, array $context = []): bool
    {
        if (is_countable($input)) {
            return count($input) <= $this->size;
        }

        if (is_iterable($input)) {
            $count = 0;
            foreach ($input as $v) {
                $count++;
                if ($count > $this->size) {
                    return false;
                }
            }

            return $count <= $this->size;
        }

        return false;
    }
}
