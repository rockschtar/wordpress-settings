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

    private $disabled;

    /**
     * @return bool
     */
    public function isDisabled(): bool {
        return $this->disabled;
    }

    /**
     * @param bool $disabled
     * @return FieldListItem
     */
    public function setDisabled(bool $disabled): FieldListItem {
        $this->disabled = $disabled;
        return $this;
    }


    /**
     * CheckboxListItem constructor.
     * @param string $label
     * @param string $value
     * @param bool $disabled
     */
    public function __construct(string $label, string $value, bool $disabled = false) {
        $this->label = $label;
        $this->value = $value;
        $this->disabled = $disabled;
    }

    /**
     * @param string $label
     * @param string $value
     * @param bool $disabled
     * @return static
     */
    public static function create(string $label, string $value, bool $disabled = false) {
        return new self($label, $value, $disabled);
    }

    /**
     * @return string
     */
    public function getLabel(): string {
        return $this->label;
    }

    /**
     * @param string $label
     * @return FieldListItem
     */
    public function setLabel(string $label): FieldListItem {
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
     * @return FieldListItem
     */
    public function setValue(string $value): FieldListItem {
        $this->value = $value;
        return $this;
    }


}