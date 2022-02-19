<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Type;

use BrenoRoosevelt\Validation\AbstractRule;
use BrenoRoosevelt\Validation\StopSign;
use BrenoRoosevelt\Validation\Translation\Translator;

abstract class TypeRule extends AbstractRule
{
    const MESSAGE = 'Value should be of type `%s`';
    const SUB_CLASS_PREFIX_CONVENTION = 'Is';

    public function __construct(
        ?string $message = null,
        int $stopOnFailure = StopSign::DONT_STOP,
        int $priority = 0
    ) {
        parent::__construct($message, $stopOnFailure, $priority);
    }

    protected function typeName(): string
    {
        $prefixSize = strlen(self::SUB_CLASS_PREFIX_CONVENTION);
        return lcfirst(substr($this->className(), $prefixSize));
    }

    public function translatedMessage(): ?string
    {
        return Translator::translate(self::MESSAGE, $this->typeName());
    }
}
