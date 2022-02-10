<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

interface Stopable extends Rule
{
    public function stopOnFailure(): bool;
}
