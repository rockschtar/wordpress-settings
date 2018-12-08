<?php
/**
 * Created by PhpStorm.
 * User: Stefan Helmer
 * Date: 27.11.2018
 * Time: 19:54
 */

namespace Rockschtar\WordPress\Settings\Fields;


use Rockschtar\WordPress\Settings\Models\Field;
use Rockschtar\WordPress\Settings\Models\HTMLTag;

class CheckBox extends Field {

    /**
     * @var String|null
     */
    private $value;

    public function getHTMLTag($current_value): HTMLTag {
        $html_tag = parent::getHTMLTag($current_value);

        $html_tag->setAttribute('type', 'checkbox');

        if ($this->getValue() === $current_value) {
            $html_tag->setAttribute('checked', null);
        }

        $html_tag->setAttribute('value', $this->getValue());

        if ($this->isReadonly()) {
            $html_tag->setAttribute('disabled', null);
        }

        return $html_tag;
    }


    /**
     * @param $current_value
     * @param array $args
     * @return string
     */
    public function inputHTML($current_value, array $args = []): string {
        $html_tag = $this->getHTMLTag($current_value);

        $hidden_tag = new HTMLTag('input');
        $hidden_tag->setAttribute('type', 'hidden');
        $hidden_tag->setAttribute('name', $this->getId());
        $hidden_tag->setAttribute('value', $this->getValue());

        return $html_tag->buildTag() . $hidden_tag->buildTag();

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