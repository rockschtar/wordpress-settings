<?php

namespace Rockschtar\WordPress\Settings\Fields;

class Custom extends Field
{
    private $contentCallback;

    private ?string $content = null;

    public function output($currentValue, array $args = []): string
    {
        if ($this->contentCallback === null) {
            return '';
        }

        return call_user_func($this->contentCallback, $this, $currentValue, $args);
    }

    public function setContentCallback(callable $contentCallback): Custom
    {
        $this->contentCallback = $contentCallback;
        return $this;
    }
}
