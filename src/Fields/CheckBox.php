<?php

namespace Rockschtar\WordPress\Settings\Fields;

use Rockschtar\WordPress\Settings\Traits\AutofocusTrait;
use Rockschtar\WordPress\Settings\Traits\DisabledTrait;
use Rockschtar\WordPress\Settings\Traits\ReadOnlyTrait;

class CheckBox extends Field
{
    use DisabledTrait;

    use ReadOnlyTrait;

    use AutofocusTrait;

    private mixed $value = null;

    public function output($currentValue, array $args = []): string
    {

        $readonly = $this->isReadonly() ? 'readonly' : '';
        $disabled = $this->isDisabled() ? 'disabled' : '';
        $autofocus = $this->isAutofocus() ? 'autofocus' : '';
        $checked = checked($this->getValue(), $currentValue, false);

        $output = <<<HTML
            <input 
                type="checkbox" 
                id="{$this->getId()}"
                name="{$this->getId()}"
                $readonly 
                $disabled 
                $autofocus
                $checked
                value="{$this->getValue()}" 
            />
        HTML;


        return $output;
    }

    /**
     * @return String|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param String|null $value
     * @return CheckBox
     */
    public function setValue(?string $value): CheckBox
    {
        $this->value = $value;
        return $this;
    }
}
