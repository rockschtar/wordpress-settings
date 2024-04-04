<?php

namespace Rockschtar\WordPress\Settings\Fields;

class Custom extends Field
{
    private ?string $content = null;

    public function output($currentValue, array $args = []): string
    {
        return $this->getContent();
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): Custom
    {
        $this->content = $content;
        return $this;
    }
}
