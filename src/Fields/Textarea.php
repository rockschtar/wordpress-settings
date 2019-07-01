<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Fields;


use Rockschtar\WordPress\Settings\Models\Field;
use Rockschtar\WordPress\Settings\Models\HTMLTag;

class Textarea extends Field {

    /**
     * @param $current_value
     * @param array $args
     * @return string
     */
    public function inputHTML($current_value, array $args = []): string {

        return $this->getHTMLTag($current_value)->buildTag();
    }

    /**
     * @param $current_value
     * @return HTMLTag
     */
    public function getHTMLTag($current_value): HTMLTag {

        $html_tag = parent::getHTMLTag($current_value);
        $html_tag->setTag('textarea');
        $html_tag->setAttribute('type', 'null');

        return apply_filters('rwps_html_tag', $html_tag, $this->getId());
    }
}