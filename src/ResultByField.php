<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

interface ResultByField extends Result
{
    /**
     * @return string
     */
    public function getField(): string;
}
