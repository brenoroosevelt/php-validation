<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Generic extends AbstractRule
{
    const MESSAGE = 'Invalid input';

    /** @var callable */
    private $callback;

    public function __construct(
        callable $callback,
        ?string  $message = null,
        ?int     $stopOnFailure = null,
        ?int     $priority = null
    ) {
        $this->callback = $callback;
        parent::__construct($message, $stopOnFailure, $priority);
    }

    public function isValid($input, array $context = []): bool
    {
        return call_user_func_array($this->callback, [$input, $context]);
    }
}
