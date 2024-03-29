<?php

namespace Rockschtar\WordPress\Settings\Fields;

class InputPhone extends Input
{
    private ?int $maxlength = null;

    private ?int $minlength = null;

    private ?string $pattern = null;

    public function getMinlength(): ?int
    {
        return $this->minlength;
    }

    public function setMinlength(?int $minlength): InputPhone
    {
        $this->minlength = $minlength;
        return $this;
    }

    public function getMaxlength(): ?int
    {
        return $this->maxlength;
    }

    public function setMaxlength(?int $maxlength): InputPhone
    {
        $this->maxlength = $maxlength;
        return $this;
    }

    public function getPattern(): ?string
    {
        return $this->pattern;
    }

    public function setPattern(?string $pattern): InputPhone
    {
        $this->pattern = $pattern;
        return $this;
    }

    public function attributes(): array
    {
        $attributes = [];
        if ($this->maxlength) {
            $attributes['maxlength'] = $this->getMaxlength();
        }
        if ($this->minlength) {
            $attributes['minlength'] = $this->getMinlength();
        }
        if ($this->pattern) {
            $attributes['pattern'] = $this->getPattern();
        }
        return $attributes;
    }
}
