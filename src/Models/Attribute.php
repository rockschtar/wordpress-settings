<?php

namespace Rockschtar\WordPress\Settings\Models;

/**
 * Class Attribute
 * @package Rockschtar\WordPress\Settings
 */
class Attribute {

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    /**
     * Attribute constructor.
     * @param string $name
     * @param string $value
     */
    public function __construct(string $name, string $value) {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Attribute
     */
    public function setName(string $name): Attribute {
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
     * @return Attribute
     */
    public function setValue(string $value): Attribute {
        $this->value = $value;
        return $this;
    }

    /**
     * Attribute constructor.
     * @param string $name
     * @param string $value
     * @return Attribute
     */
    public static function create(string $name, string $value): Attribute {
        return new self($name, $value);
    }

}