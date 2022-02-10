<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Exception;

use Exception;

class ValidationException extends Exception implements ValidationExceptionInterface
{
    use ValidationExceptionTrait;
}
