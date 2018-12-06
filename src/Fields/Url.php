<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Fields;


class Url extends Phone {

    public function inputHTML($current_value, array $args = []): string {
        $html = parent::inputHTML($current_value, $args);
        return str_replace('type="phone"', 'type="url"', $html);
    }


}