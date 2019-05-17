<?php

namespace Rockschtar\WordPress\Settings\Models;

/**
 * Class SelectBoxItem
 * @package Rockschtar\WordPress\Settings
 */
class SelectBoxItem {

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    /**
     * @var bool
     */
    private $disabled;

    /**
     * SelectBoxItem constructor.
     * @param string $value
     * @param string $name
     * @param bool $disabled
     */
    public function __construct(string $value, string $name, bool $disabled = false) {
        $this->name = $name;
        $this->value = $value;
        $this->disabled = $disabled;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @param string $name
     * @return SelectBoxItem
     */
    public function setName(string $name): SelectBoxItem {
        $this->name = $name;
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
     * @return SelectBoxItem
     */
    public function setValue(string $value): SelectBoxItem {
        $this->value = $value;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDisabled(): bool {
        return $this->disabled;
    }

    /**
     * @param bool $disabled
     * @return SelectBoxItem
     */
    public function setDisabled(bool $disabled): SelectBoxItem {
        $this->disabled = $disabled;
        return $this;
    }

    /**
     * Create SelectBoxItem.
     * @param string $value
     * @param string $name
     * @param bool $disabled
     * @return SelectBoxItem
     */
    public static function create(string $value, string $name, bool $disabled = false): SelectBoxItem {
        return new self($value, $name, $disabled);
    }

}