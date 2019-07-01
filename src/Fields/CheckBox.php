<?php

namespace Rockschtar\WordPress\Settings\Fields;

use Rockschtar\WordPress\Settings\Models\Field;
use Rockschtar\WordPress\Settings\Models\HTMLTag;
use Rockschtar\WordPress\Settings\Traits\ReadOnlyTrait;

/**
 * Class CheckBox
 * @package Rockschtar\WordPress\Settings
 */
class CheckBox extends Field {

    /**
     * @var String|null
     */
    private $value;

    /**
     * @param $current_value
     * @return HTMLTag
     */
    public function getHTMLTag($current_value): HTMLTag {
        $html_tag = parent::getHTMLTag($current_value);

        $html_tag->setAttribute('type', 'checkbox');

        if ($this->getValue() === $current_value) {
            $html_tag->setAttribute('checked');
        }

        $html_tag->setAttribute('value', $this->getValue());

        return apply_filters('rwps_html_tag', $html_tag, $this->getId());
    }

    /**
     * @param $current_value
     * @param array $args
     * @return string
     */
    public function inputHTML($current_value, array $args = []): string {
        $html_tag = $this->getHTMLTag($current_value);

        if ($this->isReadonly()) {
            $hidden_tag = new HTMLTag('input');
            $hidden_tag->setAttribute('type', 'hidden');
            $hidden_tag->setAttribute('name', $this->getId());
            $hidden_tag->setAttribute('value', $this->getValue());
            return $html_tag->buildTag() . $hidden_tag->buildTag();
        }

        return $html_tag->buildTag();
    }

    /**
     * @return String|null
     */
    public function getValue(): ?String {
        return $this->value;
    }

    /**
     * @param String|null $value
     * @return CheckBox
     */
    public function setValue(?String $value): CheckBox {
        $this->value = $value;
        return $this;
    }
}