<?php


namespace Rockschtar\WordPress\Settings\Traits;


trait DisabledTrait {

    /**
     * @var bool
     */
    private $disabled = false;

    /**
     * @return bool
     */
    public function isDisabled(): bool {
        return $this->disabled;
    }

    /**
     * @param bool $disabled
     * @return static
     */
    public function setDisabled(bool $disabled) {
        $this->disabled = $disabled;
        return $this;
    }




}