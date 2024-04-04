<?php

namespace Rockschtar\WordPress\Settings\Traits;

trait RequiredTrait
{
    private bool $required = false;

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function setRequired(bool $required): static
    {
        $this->required = $required;
        return $this;
    }
}
