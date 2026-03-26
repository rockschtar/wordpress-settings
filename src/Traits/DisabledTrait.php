<?php

namespace Rockschtar\WordPress\Settings\Traits;

trait DisabledTrait
{
    private bool $disabled = false;

    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    public function setDisabled(bool $disabled): static
    {
        $this->disabled = $disabled;
        return $this;
    }
}
