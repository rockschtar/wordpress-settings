<?php

namespace Rockschtar\WordPress\Settings\Fields;

/**
 * Class Url
 * @package Rockschtar\WordPress\Settings
 */
class Url extends Phone {

    /**
     * @param $current_value
     * @param array $args
     * @return string
     */
    public function inputHTML($current_value, array $args = []): string {
        $html = parent::inputHTML($current_value, $args);
        return str_replace('type="phone"', 'type="url"', $html);
    }


}