<?php
/**
 * Created by PhpStorm.
 * User: Stefan Helmer
 * Date: 27.11.2018
 * Time: 19:35
 */

namespace Rockschtar\WordPress\Settings\Fields;


use Rockschtar\WordPress\Settings\Models\Field;

class Textfield extends Field {

    public const TEXT = 'text';
    public const COLOR = 'color';
    public const DATE = 'date';
    public const PHONE = 'tel';
    public const NUMBER = 'number';
    public const PASSWORD = 'password';
    public const URL = 'url';

    /**
     * @var string
     */
    private $type = self::TEXT;

    /**
     * @var String|null
     */
    private $placeholder;

    /**
     * @var int|null
     */
    private $size;

    /**
     * @return int|null
     */
    public function getSize(): ?int {
        return $this->size;
    }

    /**
     * @param int|null $size
     * @return Textfield
     */
    public function setSize(?int $size): Textfield {
        $this->size = $size;
        return $this;
    }

    /**
     * @param $current_value
     * @param array $args
     * @return string
     */
    public function inputHTML($current_value, array $args = []): string {
        return sprintf('<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" size="%5$s" />', $this->getId(), $this->getType(), $this->getPlaceholder(), $current_value, $this->getSize());
    }

    /**
     * @return string
     */
    public function getType(): string {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Textfield
     */
    public function setType(string $type): Textfield {
        $this->type = $type;
        return $this;
    }

    /**
     * @return String|null
     */
    public function getPlaceholder(): ?String {
        return $this->placeholder;
    }

    /**
     * @param String|null $placeholder
     * @return Textfield
     */
    public function setPlaceholder(?String $placeholder): Textfield {
        $this->placeholder = $placeholder;
        return $this;
    }
}