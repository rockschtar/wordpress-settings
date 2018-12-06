<?php
/**
 * Created by PhpStorm.
 * User: Stefan Helmer
 * Date: 27.11.2018
 * Time: 19:54
 */

namespace Rockschtar\WordPress\Settings\Fields;


use Rockschtar\WordPress\Settings\Models\Field;

class CheckBox extends Field {

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
        return sprintf('<input name="%1$s" id="%1$s" type="checkbox" %2$s value="%3$s" %4$s />', $this->getId(), $checked, $this->getValue(), disabled($this->isDisabled(), true, false));
    }

    /**
     * @return String|null
     */
    public function getValue(): ?String {
        return $this->value;
    }

    /**
     * @param String|null $value
     * @return CheckBox
     */
    public function setValue(?String $value): CheckBox {
        $this->value = $value;
        return $this;
    }
}