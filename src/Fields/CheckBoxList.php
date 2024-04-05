<?php

namespace Rockschtar\WordPress\Settings\Fields;

use Rockschtar\WordPress\Settings\Models\ListItem;
use Rockschtar\WordPress\Settings\Traits\DisabledTrait;

use function is_array;

class CheckBoxList extends Field
{
    use DisabledTrait;

    /**
     * @var ListItem[]
     */
    private array $items = [];

    public function addItem(ListItem $item): CheckBoxList
    {
        $this->items[] = $item;

        return $this;
    }

    public function output($currentValue, array $args = []): string
    {

        $html = '';
        $iterator = 0;

        if ($this instanceof Radio) {
            $type = 'radio';
        } else {
            $type = 'checkbox';
        }

        foreach ($this->getItems() as $item) {
            $iterator++;
            $checked = false;

            if (is_array($currentValue)) {
                foreach ($currentValue as $value) {
                    if ($item->getValue() === $value) {
                        $checked = checked(true, true, false);
                        break;
                    }
                }
            }

            $disabled = $this->isDisabled() || $item->isDisabled();

            $html .= sprintf(
                '<label for="%1$s_%6$s"><input id="%1$s_%6$s" name="%1$s[]" type="%2$s" value="%3$s" %4$s %5$s %7$s /> %5$s</label><br/>',
                $this->getId(),
                $type,
                $item->getValue(),
                $checked,
                $item->getName(),
                $iterator,
                disabled($disabled, true, false)
            );
        }

        return sprintf('<fieldset>%s</fieldset>', $html);
    }

    /**
     * @return ListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
