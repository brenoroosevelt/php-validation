<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Comparison;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use BrenoRoosevelt\Validation\Comparator;
use BrenoRoosevelt\Validation\Translation\Translator;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Compare extends AbstractRule
{
    const MESSAGE = 'Value should be %s `%s`';

    use Comparator;

    public function __construct(
        protected string $operator,
        protected mixed $value,
        ?string $message = null,
        ?int $stopOnFailure = null,
        ?int $priority = null
    ) {
        parent::__construct($message, $stopOnFailure, $priority);
    }

    public function isValid($input, array $context = []): bool
    {
        return $this->compare($input, $this->operator, $this->value);
    }

    public function translatedMessage(): ?string
    {
        $translatedOperator = Translator::translate($this->operator);
        return Translator::translate(self::MESSAGE, $translatedOperator, $this->value);
    }
}
