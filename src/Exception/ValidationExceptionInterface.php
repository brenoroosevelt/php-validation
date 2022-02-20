<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Exception;

use BrenoRoosevelt\Validation\Contracts\Error;
use Throwable;

interface ValidationExceptionInterface extends Throwable
{
    /**
     * @return Error[]
     */
    public function getErrors(): array;
}
