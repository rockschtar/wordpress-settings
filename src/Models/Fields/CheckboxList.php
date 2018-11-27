<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Models\Fields;

use Rockschtar\WordPress\Settings\Models\Field;
use Rockschtar\WordPress\Settings\Models\FieldListItem;

class CheckboxList extends Field {

    /**
     * @var FieldListItem[]
     */
    private $items = [];

    /**
     * @return FieldListItem[]
     */
    public function getItems(): array {
        return $this->items;
    }

    public function addItem(FieldListItem $item): CheckboxList {
        $this->items[] = $item;

        return $this;
    }
}