<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Models\Fields;


use Rockschtar\WordPress\Settings\Models\Field;

class WYSIWYG extends Field {

    /**
     * @var array
     */
    private $settings = [];

    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * @return array
     */
    public function getSettings(): array {
        return $this->settings;
    }

    /**
     * @param array $settings
     * @return WYSIWYG
     */
    public function setSettings(array $settings): WYSIWYG {
        $this->settings = $settings;
        return $this;
    }

    /**
     * @return int
     */
    public function getWidth(): ?int {
        return $this->width;
    }

    /**
     * @param int $width
     * @return WYSIWYG
     */
    public function setWidth(int $width): WYSIWYG {
        $this->width = $width;
        return $this;
    }

    /**
     * @return int
     */
    public function getHeight(): ?int {
        return $this->height;
    }

    /**
     * @param int $height
     * @return WYSIWYG
     */
    public function setHeight(int $height): WYSIWYG {
        $this->height = $height;
        return $this;
    }
}