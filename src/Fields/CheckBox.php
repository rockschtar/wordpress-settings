<?php

namespace Rockschtar\WordPress\Settings\Fields;

use Rockschtar\WordPress\Settings\Models\Field;
use Rockschtar\WordPress\Settings\Models\HTMLTag;
use Rockschtar\WordPress\Settings\Traits\AutofocusTrait;
use Rockschtar\WordPress\Settings\Traits\DisabledTrait;
use Rockschtar\WordPress\Settings\Traits\ReadOnlyTrait;

/**
 * Class CheckBox
 * @package Rockschtar\WordPress\Settings
 */
class CheckBox extends Field {

    use DisabledTrait;

    use ReadOnlyTrait;

    use AutofocusTrait;

    /**
     * @var String|null
     */
    private $value;

    /**
     * @param $current_value
     * @return HTMLTag
     */
    protected function getHTMLTag($current_value): HTMLTag {
        $htmlTag = new HTMLTag('input');

        $htmlTag->setAttribute('type', 'checkbox');
        $htmlTag->setAttribute('id', $this->getId());
        $htmlTag->setAttribute('name', $this->getId());

        if ($this->getValue() === $current_value) {
            $htmlTag->setAttribute('checked');
        }

        if ($this->isDisabled()) {
            $htmlTag->setAttribute('disabled');
        }

        if ($this->isAutofocus()) {
            $htmlTag->setAttribute('autofocus');
        }

        if($this->isReadonly()) {
            $htmlTag->setAttribute('readonly');
            $htmlTag->setAttribute('onclick', 'return false;');
        }

        $htmlTag->setAttribute('value', $this->getValue());

        return $htmlTag;
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