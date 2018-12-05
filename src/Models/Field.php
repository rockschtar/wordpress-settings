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
     * @var array
     */
    private $arguments = [];

    /**
     * Field constructor.
     * @param $id
     */
    public function __construct($id) {
        $this->setId($id);
    }


    /**
     * @param string $id
     * @return static
     */
    public static function create(string $id) {
        $class = static::class;
        return new $class($id);
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
     * @throws \InvalidArgumentException
     */
    public function setId($id) {

        $validate = preg_match_all('/^[a-zA-Z0-9_-]+$/i', $id, $result) === 1;

        if (!$validate) {
            throw new \InvalidArgumentException('Id ' . $id . ' is invalid or missing. Allowed characters: A-Z, a-z, 0-9, _ and - ');
        }

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
     * @return static
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * @return array
     */
    public function getArguments(): array {
        return $this->arguments;
    }

    /**
     * @param array $arguments
     * @return static
     */
    public function setArguments(array $arguments) {
        $this->arguments = $arguments;
        return $this;
    }

    final public function output($current_value, array $args = []): string {
        $output = apply_filters('rwps-field-html', $this->inputHTML($current_value, $args), $this->getId());
        if (!empty($this->getDescription())) {
            $output .= sprintf('<p class="description">%s </p>', $this->getDescription());

        }
        $output = apply_filters('rwps-field', $output, $this->getId());
        $output = apply_filters('rwps-field-' . $this->getId(), $output);

        return $output;
    }

    /**
     * @param $current_value
     * @param array $args
     * @return string
     */
    abstract public function inputHTML($current_value, array $args = []): string;

}