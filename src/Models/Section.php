<?php

namespace Rockschtar\WordPress\Settings\Models;

/**
 * Class Section
 * @package Rockschtar\WordPress\Settings
 */
class Section {

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string|array
     */
    private $callback = array();

    /**
     * @var Field[]
     */
    private $fields = [];

    /**
     * Section constructor.
     */
    public function __construct() {

    }

    /**
     * @return Section
     */
    public static function create(): Section {
        return new self();
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Section
     */
    public function setId($id): Section {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Section
     */
    public function setTitle($title): Section {
        $this->title = $title;
        return $this;
    }

    /**
     * @return array|string
     */
    public function getCallback() {
        return $this->callback;
    }

    /**
     * @param array|string $callback
     * @return Section
     */
    public function setCallback($callback): Section {
        $this->callback = $callback;
        return $this;
    }

    /**
     * @return Field[]
     */
    public function getFields(): array {
        return $this->fields;
    }

    /**
     * @param mixed $fields
     * @return Section
     */
    public function setFields($fields): Section {
        $this->fields = $fields;
        return $this;
    }

    /**
     * @param Field $field
     * @return Section
     */
    public function addField(Field $field): Section {
        $this->fields[] = $field;
        return $this;
    }

}