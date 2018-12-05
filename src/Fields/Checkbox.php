<?php
/**
 * Created by PhpStorm.
 * User: Stefan Helmer
 * Date: 27.11.2018
 * Time: 19:54
 */

namespace Rockschtar\WordPress\Settings\Fields;


use Rockschtar\WordPress\Settings\Models\Field;

class Checkbox extends Field {

    /**
     * @var String|null
     */
    private $value;

    /**
     * @param $current_value
     * @param array $args
     * @return string
     */
    public function inputHTML($current_value, array $args = []): string {
        $checked = checked($this->getValue(), $current_value, false);
        return sprintf('<input name="%1$s" id="%1$s" type="checkbox" %2$s value="%3$s" />', $this->getId(), $checked, $this->getValue());
    }

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