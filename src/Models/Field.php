<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Models;

abstract class Field {

    /**
     * @var
     */
    private $label;

    /**
     * @var
     */
    private $id;


    /**
     * @var
     */
    private $description;

    /**
     * @return static
     */
    public static function create() {
        $class = \get_called_class();
        return new $class;
    }

    /**
     * @return mixed
     */
    public function getLabel() {
        return $this->label;
    }

    /**
     * @param mixed $label
     * @return static
     */
    public function setLabel($label) {
        $this->label = $label;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return static
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Field
     */
    public function setDescription($description): Field {
        $this->description = $description;
        return $this;
    }

}