<?php

namespace Rockschtar\WordPress\Settings\Traits;

trait AutofocusTrait
{
    private bool $autofocus = false;


    public function isAutofocus(): bool
    {
        return $this->autofocus;
    }


    public function setAutofocus(bool $autofocus): static
    {
        $this->autofocus = $autofocus;
        return $this;
    }
}
