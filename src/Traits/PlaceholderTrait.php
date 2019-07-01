<?php


namespace Rockschtar\WordPress\Settings\Traits;


/**
 * Trait PlaceholderTrait
 * @package Rockschtar\WordPress\Settings\Traits
 */
trait PlaceholderTrait {

    /**
     * @var string|null
     */
    private $placeholder;

    /**
     * @return string|null
     */
    public function getPlaceholder(): ?string {
        return $this->placeholder;
    }

    /**
     * @param string|null $placeholder
     * @return static
     */
    public function setPlaceholder(?string $placeholder) {
        $this->placeholder = $placeholder;
        return $this;
    }


}