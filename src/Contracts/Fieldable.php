<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Contracts;

interface Fieldable extends Rule
{
    /**
     * @param string|null $field
     * @return $this
     */
    public function setField(?string $field = null): static;

    /**
     * @return string|null
     */
    public function getField(): ?string;
}
