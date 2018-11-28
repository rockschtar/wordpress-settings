<?php
/**
 * Created by PhpStorm.
 * User: Stefan Helmer
 * Date: 27.11.2018
 * Time: 19:35
 */

namespace Rockschtar\WordPress\Settings\Models;


use Rockschtar\WordPress\Settings\Enum\TextfieldType;

class Textfield extends Field {

    /**
     * @var string
     */
    private $type = TextfieldType::TEXT;

    /**
     * @var String|null
     */
    private $placeholder;

    /**
     * @var int|null
     */
    private $size;

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
     * @return string
     */
    public function getType(): string {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): Textfield {
        $this->type = $type;
        return $this;
    }


}