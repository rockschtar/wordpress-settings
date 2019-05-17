<?php

namespace Rockschtar\WordPress\Settings\Fields;

use Rockschtar\WordPress\Settings\Models\Field;
use Rockschtar\WordPress\Settings\Models\SelectBoxItem;
use function is_array;

/**
 * Class SelectBox
 * @package Rockschtar\WordPress\Settings\Fields
 */
class SelectBox extends Field {

    /**
     * @var bool
     */
    private $multiselect = false;

    /**
     * @var SelectBoxItem[]
     */
    private $items = [];

    /**
     * SelectBox constructor.
     * @param string $id
     */
    public function __construct(string $id) {
        parent::__construct($id);
    }

    /**
     * @param SelectBoxItem $item
     * @return SelectBox
     */
    public function addItem(SelectBoxItem $item): SelectBox {
        $this->items[] = $item;
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

            if (is_array($current_value)) {
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
     * @return SelectBoxItem[]
     */
    public function getItems(): array {
        return $this->items;
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