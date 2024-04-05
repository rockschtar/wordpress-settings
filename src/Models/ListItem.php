<?php

namespace Rockschtar\WordPress\Settings\Models;

class ListItem
{
    private string $name;

    private string $value;

    private bool $disabled;

    public function __construct(string $value, string $name, bool $disabled = false)
    {
        $this->name = $name;
        $this->value = $value;
        $this->disabled = $disabled;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): ListItem
    {
        $this->name = $name;
        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): ListItem
    {
        $this->value = $value;
        return $this;
    }

    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    public function setDisabled(bool $disabled): ListItem
    {
        $this->disabled = $disabled;
        return $this;
    }

    public static function create(string $value, string $name, bool $disabled = false): ListItem
    {
        return new self($value, $name, $disabled);
    }
}
