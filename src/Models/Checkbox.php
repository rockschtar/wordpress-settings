<?php
/**
 * Created by PhpStorm.
 * User: Stefan Helmer
 * Date: 27.11.2018
 * Time: 19:54
 */

namespace Rockschtar\WordPress\Settings\Models;


class Checkbox extends Field{

    /**
     * @var String|null
     */
    private $value;

    /**
     * @return String|null
     */
    public function getValue(): ?String {
        return $this->value;
    }

    /**
     * @param String|null $value
     * @return Checkbox
     */
    public function setValue(?String $value): Checkbox {
        $this->value = $value;
        return $this;
    }



}