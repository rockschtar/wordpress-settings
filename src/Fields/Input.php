<?php

namespace Rockschtar\WordPress\Settings\Fields;

use Rockschtar\WordPress\Settings\Enums\InputType;
use Rockschtar\WordPress\Settings\Models\Datalist;
use Rockschtar\WordPress\Settings\Traits\AutofocusTrait;
use Rockschtar\WordPress\Settings\Traits\CssClassTrait;
use Rockschtar\WordPress\Settings\Traits\DisabledTrait;
use Rockschtar\WordPress\Settings\Traits\PlaceholderTrait;
use Rockschtar\WordPress\Settings\Traits\ReadOnlyTrait;
use Rockschtar\WordPress\Settings\Traits\RequiredTrait;

abstract class Input extends Field
{
    use DisabledTrait;

    use ReadOnlyTrait;

    use PlaceholderTrait;

    use AutofocusTrait;

    use RequiredTrait;

    use CssClassTrait;

    private ?int $size = null;

    private InputType $inputType;

    private ?array $datalist = null;

    public function __construct(string $id, InputType $type = InputType::text)
    {
        parent::__construct($id);
        $this->inputType = $type;
    }

    public function setSize(?int $size): static
    {
        $this->size = $size;
        return $this;
    }


    public function getSize(): ?int
    {
        return $this->size;
    }


    /**
     * @return String|null
     */
    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    public function setPlaceholder(?string $placeholder): static
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function getDatalist(): ?array
    {
        return $this->datalist;
    }

    public function setDatalist(array $datalist): static
    {
        $this->datalist = $datalist;
        return $this;
    }

    public function addDatalistItem(string $item): static
    {
        if ($this->getDatalist() === null) {
            $this->setDatalist([]);
        }

        $this->datalist[] = $item;
        return $this;
    }

    public function addDataListItems(string ...$items): static
    {
        foreach ($items as $item) {
            $this->addDatalistItem($item);
        }

        return $this;
    }

    protected function getDatalistId(): string
    {
        return $this->getId() . '_datalist';
    }

    protected function getDatalistHTML(): string
    {
        if ($this->getDatalist() === null) {
            return '';
        }

        $datalist_id = $this->getDatalistId();
        $datalist = sprintf('<datalist id="%s">', $datalist_id);

        foreach ($this->getDatalist() as $item) {
            $datalist .= sprintf('<option value="%s">', $item);
        }

        $datalist .= '</datalist>';

        return $datalist;
    }

    abstract public function attributes(): array;

    public function output(mixed $currentValue, array $args = []): string
    {
        $readonly = $this->isReadonly() ? 'readonly' : '';
        $disabled = $this->isDisabled() ? 'disabled' : '';
        $autofocus = $this->isAutofocus() ? 'autofocus' : '';
        $required = $this->isRequired() ? 'required' : '';
        $list = $this->getDatalist() ? 'list="' . $this->getDatalistId() . '"' : '';
        $size = $this->getSize() ? 'size="' . $this->getSize() . '"' : '';
        $dataList = $this->getDatalistHTML();
        $class = empty($this->getCssClassesAsString()) ? '' : 'class="' . $this->getCssClassesAsString() . '"';

        $b = $this->attributes();
        $attributes = [];
        foreach ($this->attributes() as $key => $value) {
            $attributes[] = $key . '="' . $value . '"';
        }

        $additionalAttributes = implode(' ', $attributes);

        $output = <<<HTML
            <input 
                type="{$this->inputType->name}" 
                id="{$this->getId()}" 
                $class
                $readonly
                $disabled
                $autofocus
                $required
                $list
                $size
                $additionalAttributes
                placeholder="{$this->getPlaceholder()}"
                name="{$this->getId()}" 
                value="{$currentValue}" 
            /> 
            $dataList
        HTML;

        return $output;
    }
}
