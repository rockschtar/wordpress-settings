<?php
namespace Rockschtar\WordPress\Settings\Fields;

use Rockschtar\WordPress\Settings\Models\Field;
use Rockschtar\WordPress\Settings\Models\SelectBoxItem;

/**
 * Class CheckBoxList
 * @package Rockschtar\WordPress\Settings
 */
class CheckBoxList extends Field {

    /**
     * @var SelectBoxItem[]
     */
    private $items = [];

    /**
     * @param SelectBoxItem $item
     * @return CheckBoxList
     */
    public function addItem(SelectBoxItem $item): CheckBoxList {
        $this->items[] = $item;

        return $this;
    }

    /**
     * @param $current_value
     * @param array $args
     * @return string
     */
    public function inputHTML($current_value, array $args = []): string {
        $options_markup = '';
        $iterator = 0;

        if (\get_class($this) === Radio::class) {
            $type = 'radio';
        } else {
            $type = 'checkbox';
        }

        foreach ($this->getItems() as $item) {
            $iterator++;
            $checked = false;

            if (\is_array($current_value)) {
                foreach ($current_value as $value) {
                    if ($item->getValue() === $value) {
                        $checked = checked(true, true, false);
                        break;
                    }
                }
            }

            $disabled = $this->isDisabled() ? true : $item->isDisabled();


            $options_markup .= sprintf('<label for="%1$s_%6$s"><input id="%1$s_%6$s" name="%1$s[]" type="%2$s" value="%3$s" %4$s %5$s %7$s /> %5$s</label><br/>', $this->getId(), $type, $item->getValue(), $checked, $item->getName(), $iterator, disabled($disabled, true, false));
        }

        return sprintf('<fieldset>%s</fieldset>', $options_markup);
    }

    /**
     * @return SelectBoxItem[]
     */
    public function getItems(): array {
        return $this->items;
    }
}