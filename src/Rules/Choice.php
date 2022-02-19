<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use BrenoRoosevelt\Validation\StopSign;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Choice extends AbstractRule
{
    const MESSAGE = 'Invalid choice, accepted values: %s';

    public function __construct(
        private array $list,
        private bool $strict = true,
        ?string $message = null,
        int $stopOnFailure = StopSign::DONT_STOP
    ) {
        $message = $message ?? sprintf(self::MESSAGE, implode(', ', $this->list));
        parent::__construct($message, $stopOnFailure);
    }

    public function isValid($input, array $context = []): bool
    {
        return in_array($input, $this->list, $this->strict);
    }
}
