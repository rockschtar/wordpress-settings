<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Traits;


trait AutofocusTrait {

    /**
     * @var bool
     */
    private $autofocus = false;

    /**
     * @return bool
     */
    public function isAutofocus(): bool {
        return $this->autofocus;
    }

    /**
     * @param bool $autofocus
     * @return static
     */
    public function setAutofocus(bool $autofocus) {
        $this->autofocus = $autofocus;
        return $this;
    }
}