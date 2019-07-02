<?php

namespace Rockschtar\WordPress\Settings\Fields;

use Rockschtar\WordPress\Settings\Models\Field;
use Rockschtar\WordPress\Settings\Models\HTMLTag;
use Rockschtar\WordPress\Settings\Traits\DisabledTrait;
use Rockschtar\WordPress\Settings\Traits\ReadOnlyTrait;

/**
 * Class CheckBox
 * @package Rockschtar\WordPress\Settings
 */
class CheckBox extends Field {

    use DisabledTrait;

    use ReadOnlyTrait;

    /**
     * @var String|null
     */
    private $value;

    /**
     * @param $current_value
     * @return HTMLTag
     */
    protected function getHTMLTag($current_value): HTMLTag {
        $html_tag = new HTMLTag('checkbox');

        $html_tag->setAttribute('id', $this->getId());
        $html_tag->setAttribute('name', $this->getId());

        if ($this->getValue() === $current_value) {
            $html_tag->setAttribute('checked');
        }

        if ($this->isDisabled()) {
            $html_tag->setAttribute('disabled');
        }

        if($this->isReadonly()) {
            $html_tag->removeAttribute('readonly');
            $html_tag->setAttribute('onclick', 'return false;');
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
        $htmlTag = $this->getHTMLTag($current_value);
        $html = apply_filters('rwps_html_tag', $htmlTag->buildTag());
        $html = apply_filters('rwps_html_tag-' . $this->getId(), $html);
        return $html;
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