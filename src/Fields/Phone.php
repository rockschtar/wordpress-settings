<?php

namespace Rockschtar\WordPress\Settings\Fields;

use Rockschtar\WordPress\Settings\Models\HTMLTag;

/**
 * Class Phone
 * @package Rockschtar\WordPress\Settings
 */
class Phone extends Textfield {

    /**
     * @var int|null
     */
    private $maxlength;

    /**
     * @var int|null
     */
    private $minlength;

    /**
     * @var string|null
     */
    private $pattern;

    /**
     * @param $current_value
     * @return HTMLTag
     */
    public function getHTMLTag($current_value): HTMLTag {
        $html_tag = parent::getHTMLTag($current_value);
        $html_tag->setAttribute('type', 'tel');
        $html_tag->setAttribute('minlength', $this->getMaxlength());
        $html_tag->setAttribute('maxlength', $this->getMinlength());
        $html_tag->setAttribute('pattern', $this->getPattern());
        return $html_tag;
    }


    /**
     * @return int|null
     */
    public function getMinlength(): ?int {
        return $this->minlength;
    }

    /**
     * @param int|null $minlength
     * @return Phone
     */
    public function setMinlength(?int $minlength): Phone {
        $this->minlength = $minlength;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMaxlength(): ?int {
        return $this->maxlength;
    }

    /**
     * @param int|null $maxlength
     * @return Phone
     */
    public function setMaxlength(?int $maxlength): Phone {
        $this->maxlength = $maxlength;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPattern(): ?string {
        return $this->pattern;
    }

    /**
     * @param string|null $pattern
     * @return Phone
     */
    public function setPattern(?string $pattern): Phone {
        $this->pattern = $pattern;
        return $this;
    }


}