<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Models;

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