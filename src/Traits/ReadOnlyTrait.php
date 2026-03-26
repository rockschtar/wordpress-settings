<?php

namespace Rockschtar\WordPress\Settings\Traits;

trait ReadOnlyTrait
{
    private bool $readonly = false;

    public function isReadonly(): bool
    {
        return $this->readonly;
    }

    public function setReadonly(bool $readonly): static
    {
        $this->readonly = $readonly;
        return $this;
    }
}
