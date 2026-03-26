<?php

namespace Rockschtar\WordPress\Settings\Traits;

trait PlaceholderTrait
{
    private ?string $placeholder = null;

    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    public function setPlaceholder(?string $placeholder): static
    {
        $this->placeholder = $placeholder;
        return $this;
    }
}
