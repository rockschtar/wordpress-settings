<?php

namespace Rockschtar\WordPress\Settings\Traits;

trait CssClassTrait
{
    /**
     * @var String[]
     */
    private array $cssClasses = [];

    public function addCssClass(string ...$cssClass): static
    {
        $this->cssClasses = array_merge($this->cssClasses, $cssClass);
        return $this;
    }

    public function getCssClassesAsString(): string
    {
        return implode(' ', $this->cssClasses);
    }
}
