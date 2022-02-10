<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

interface BelongsToField extends Rule
{
    public function setField(?string $field = null): static;
    public function getField(): ?string;
}
