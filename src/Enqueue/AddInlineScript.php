<?php

namespace Rockschtar\WordPress\Settings\Enqueue;

class AddInlineScript extends AddInlineStyle
{
    private string $position;

    public function __construct(string $handle, string $data, string $position = 'after')
    {
        parent::__construct($handle, $data);
        $this->position = $position;
    }

    public static function create(string $handle, string $data, string $position = 'after'): static
    {
        return new self($handle, $data, $position);
    }


    public function getPosition(): string
    {
        return $this->position;
    }

    public function setPosition(string $position): AddInlineScript
    {
        $this->position = $position;
        return $this;
    }
}
