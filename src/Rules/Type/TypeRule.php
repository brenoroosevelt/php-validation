<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Type;

use BrenoRoosevelt\Validation\AbstractRule;
use BrenoRoosevelt\Validation\StopSign;

abstract class TypeRule extends AbstractRule
{
    const MESSAGE = 'The value must be of type `%s`';
    const SUB_CLASS_PREFIX_CONVENTION = 'Is';

    public function __construct(
        ?string $message = null,
        int $stopOnFailure = StopSign::DONT_STOP
    ) {
        $message = $message ?? sprintf(self::MESSAGE, $this->typeName());
        parent::__construct($message, $stopOnFailure);
    }

    protected function typeName(): string
    {
        $prefixSize = strlen(self::SUB_CLASS_PREFIX_CONVENTION);
        return lcfirst(substr($this->className(), $prefixSize));
    }
}
