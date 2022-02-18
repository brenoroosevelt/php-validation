<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Exception;

use BrenoRoosevelt\Validation\Error;

trait ParseErrorsTrait
{
    /** @return Error[] */
    abstract public function getErrors(): array;

    public function errorsAsArray(): array
    {
        $errors = [];
        foreach ($this->getErrors() as $error) {
            $errors[] = [
                'field' => $error->field(),
                'message' => $error->message(),
                'type' => $error->rule() ? array_reverse(explode('\\', get_class($error->rule())))[0] : null
            ];
        }

        return $errors;
    }

    public function errorsAsString(): string
    {
        $errors = "";
        foreach ($this->errorsAsArray() as $error) {
            $errors .= sprintf(
                "\t- `%s`: %s [%s]",
                $error['field'] ?? '_error',
                $error['message'],
                $error['type'] ?? ''
            ) . PHP_EOL;
        }

        return $errors;
    }
}
