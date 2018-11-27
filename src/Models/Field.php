<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Models;

use Rockschtar\WordPress\Settings\Enum\FieldType;

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
     * @var FieldType
     */
    private $type;

    /**
     * @var
     */
    private $description;

    /**
     * @return static
     */
    public static function create()  {
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
     * @return Field
     */
    public function setLabel($label): Field  {
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
     * @return Field
     */
    public function setId($id): Field {
        $this->id = $id;
        return $this;
    }

    /**
     * @return FieldType
     */
    public function getType(): FieldType {
        return $this->type;
    }

    /**
     * @param FieldType $type
     * @return Field
     */
    public function setType(FieldType $type): Field {
        $this->type = $type;
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