<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

final class Operator
{
    const EQUAL = 'equal to';
    const EXACTLY = 'exactly';
    const GREATER_THAN = 'greater than';
    const GREATER_THAN_EQUAL = 'greater than or equal to';
    const LESS_THAN = 'less than';
    const LESS_THAN_EQUAL = 'less than or equal to';
    const NOT_EQUAL = 'not equal to';
    const NOT_EXACTLY = 'not exactly';

    /** @codeCoverageIgnore */
    private function __construct()
    {
    }
}
