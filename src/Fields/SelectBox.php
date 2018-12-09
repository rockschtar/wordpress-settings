<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Fields;

use Rockschtar\WordPress\Settings\Models\Field;
use Rockschtar\WordPress\Settings\Models\FieldListItem;
use Rockschtar\WordPress\Settings\Models\FieldListItems;

class SelectBox extends Field {

    private $multiselect = false;

    /**
     * @var FieldListItems
     */
    private $items = [];

    /**
     * SelectBox constructor.
     * @param string $id
     */
    public function __construct(string $id) {
        $this->items = new FieldListItems();
        parent::__construct($id);
    }

    public function addItem(FieldListItem $item): SelectBox {
        $this->items->append($item);
        return $this;
    }

    /**
     * @param $current_value
     * @param array $args
     * @return string
     */
    public function inputHTML($current_value, array $args = []): string {
        $attr = '';
        $options = '';

        foreach ($this->getItems() as $item) {
            $selected = false;

            if (\is_array($current_value)) {
                foreach ($current_value as $value) {
                    $selected = selected($item->getValue(), $value, false);

                    if ($selected) {
                        break;
                    }
                }
            }

            $disabled = $this->isDisabled() ? true : $item->isDisabled();


            $options .= sprintf('<option value="%s" %s %s>%s</option>', $item->getValue(), $selected, disabled($disabled, true, false), $item->getLabel());
        }

        if ($this->isMultiselect()) {
            $attr = ' multiple="multiple" ';
        }


        return sprintf('<select name="%1$s[]" id="%1$s" %2$s>%3$s</select>', $this->getId(), $attr, $options);
    }

    /**
     * @return FieldListItems
     */
    public function getItems(): FieldListItems {
        return $this->items;
    }

    /**
     * @param FieldListItems $items
     * @return SelectBox
     */
    public function setItems(FieldListItems $items): SelectBox {
        $this->items = $items;
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