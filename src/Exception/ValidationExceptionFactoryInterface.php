<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Exception;

use BrenoRoosevelt\Validation\Result;

interface ValidationExceptionFactoryInterface
{
    /**
     * @param Result $result
     * @param string|null $message
     * @return ValidationExceptionInterface
     */
    public function create(Result $result, ?string $message = null): ValidationExceptionInterface;
}
