<?php

namespace Rockschtar\WordPress\Settings\Traits;

trait ReadOnlyTrait {

    private $readonly = false;

    /**
     * @return bool
     */
    public function isReadonly(): bool {
        return $this->readonly;
    }

    /**
     * @param bool $readonly
     * @return static
     */
    public function setReadonly(bool $readonly) {
        $this->readonly = $readonly;
        return $this;
    }
}