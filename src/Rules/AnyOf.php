<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\ErrorReporting;
use BrenoRoosevelt\Validation\Contracts\Result;
use BrenoRoosevelt\Validation\Contracts\Rule;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class AnyOf implements Rule
{
    /** @var Rule[] */
    private array $rules;

    public function __construct(Rule ...$rules)
    {
        $this->rules = $rules;
    }

    public function validate(mixed $input, array $context = []): Result
    {
        $errorReporting = new ErrorReporting;
        foreach ($this->rules as $rule) {
            $result = $rule->validate($input, $context);
            if ($result->isOk()) {
                return ErrorReporting::success();
            }

            $errorReporting = $errorReporting->add($result);
        }

        return $errorReporting;
    }
}
