<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Models;


class FieldListItem {

    /**
     * @var string
     */
    private $label;


    /**
     * @var string
     */
    private $value;

    /**
     * CheckboxListItem constructor.
     * @param string $label
     * @param string $value
     */
    public function __construct(string $label, string $value) {
        $this->label = $label;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getLabel(): string {
        return $this->label;
    }

    /**
     * @param string $label
     * @return CheckboxListItem
     */
    public function setLabel(string $label): CheckboxListItem {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string {
        return $this->value;
    }

    /**
     * @param string $value
     * @return CheckboxListItem
     */
    public function setValue(string $value): CheckboxListItem {
        $this->value = $value;
        return $this;
    }


}