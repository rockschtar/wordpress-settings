<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Models;


class Section {

    /**
     * @var
     */
    private $id;

    /**
     * @var string
     */
    private $option_group = 'general';

    /**
     * @return string
     */
    public function getOptionGroup(): string {
        return $this->option_group;
    }

    /**
     * @param string $option_group
     * @return Section
     */
    public function setOptionGroup(string $option_group): Section {
        $this->option_group = $option_group;
        return $this;
    }


    /**
     * @var
     */
    private $title;

    /**
     * @var string|array
     */
    private $callback = array();

    /**
     * @var Fields
     */
    private $fields;

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
     * @return Fields
     */
    public function getFields(): Fields {
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

    public function addField(Field $field): Section {
        $this->fields->append($field);
        return $this;
    }




}