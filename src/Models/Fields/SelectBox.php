<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Models\Fields;

use Rockschtar\WordPress\Settings\Models\Field;
use Rockschtar\WordPress\Settings\Models\FieldListItem;

class SelectBox extends Field {

    private $multiselect = false;

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

    public function addItem(FieldListItem $item): SelectBox {
        $this->items[] = $item;
        return $this;
    }

    /**
     * @return bool
     */
    public function isMultiselect(): bool {
        return $this->multiselect;
    }

    /**
     * @param bool $multiselect
     * @return SelectBox
     */
    public function setMultiselect(bool $multiselect): SelectBox {
        $this->multiselect = $multiselect;
        return $this;
    }


}