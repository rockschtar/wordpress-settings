<?php

namespace Rockschtar\WordPress\Settings\Fields;

use Rockschtar\WordPress\Settings\Models\SelectBoxItem;
use Rockschtar\WordPress\Settings\Traits\AutofocusTrait;
use Rockschtar\WordPress\Settings\Traits\CssClassTrait;
use Rockschtar\WordPress\Settings\Traits\DisabledTrait;

use function is_array;

class SelectBox extends Field
{
    use AutofocusTrait;

    use DisabledTrait;

    use CssClassTrait;

    private bool $multiple = false;

    /**
     * @var SelectBoxItem[]
     */
    private array $items = [];

    public function addItem(SelectBoxItem $item): SelectBox
    {
        $this->items[] = $item;
        return $this;
    }

    public function output($currentValue, array $args = []): string
    {
        $multiple = '';
        $options = '';

        foreach ($this->getItems() as $item) {
            $selected = false;

            if (is_array($currentValue)) {
                foreach ($currentValue as $value) {
                    $selected = selected($item->getValue(), $value, false);

                    if ($selected) {
                        break;
                    }
                }
            } else {
                $selected = selected($item->getValue(), $currentValue, false);
            }

            $disabled = disabled($this->isDisabled() || $item->isDisabled(), true, false);

            $options .= <<<HTML
                <option value="{$item->getValue()}" $selected $disabled>{$item->getName()}</option>
            HTML;
        }

        $nameArray = '';
        if ($this->isMultiple()) {
            $multiple = ' multiple="multiple" ';
            $nameArray = '[]';
        }

        $autofocus = $this->isAutofocus() ? 'autofocus' : '';
        $disabled = $this->isDisabled() ? 'disabled' : '';

        return <<<HTML
            <select 
                name="{$this->getId()}$nameArray" 
                id="{$this->getId()}" 
                $multiple
                class="{$this->getCssClassesAsString()}" 
                $autofocus 
                $disabled>
                $options
            </select>
        HTML;
    }

    /**
     * @return SelectBoxItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }


    public function isMultiple(): bool
    {
        return $this->multiple;
    }

    public function setMultiple(bool $multiple): SelectBox
    {
        $this->multiple = $multiple;
        return $this;
    }
}
