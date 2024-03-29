<?php

namespace Rockschtar\WordPress\Settings\Fields;

use Rockschtar\WordPress\Settings\Models\HTMLTag;
use Rockschtar\WordPress\Settings\Traits\AutofocusTrait;
use Rockschtar\WordPress\Settings\Traits\DirnameTrait;
use Rockschtar\WordPress\Settings\Traits\DisabledTrait;
use Rockschtar\WordPress\Settings\Traits\PlaceholderTrait;
use Rockschtar\WordPress\Settings\Traits\ReadOnlyTrait;

class Textarea extends Field
{
    use ReadOnlyTrait;

    use DisabledTrait;

    use PlaceholderTrait;

    use AutofocusTrait;

    use DirnameTrait;

    private int $cols = 80;

    private int $rows = 10;

    private ?int $maxlength = null;

    private ?string $wrap = null;

    public function getCols(): int
    {
        return $this->cols;
    }

    public function setCols(int $cols): Textarea
    {
        $this->cols = $cols;
        return $this;
    }

    public function getRows(): int
    {
        return $this->rows;
    }

    public function setRows(int $rows): Textarea
    {
        $this->rows = $rows;
        return $this;
    }


    public function getMaxlength(): ?int
    {
        return $this->maxlength;
    }


    public function setMaxlength(?int $maxlength): Textarea
    {
        $this->maxlength = $maxlength;
        return $this;
    }

    public function getWrap(): ?string
    {
        return $this->wrap;
    }

    public function setWrap(string $wrap): Textarea
    {
        $this->wrap = $wrap;
        return $this;
    }

    public function output($currentValue, array $args = []): string
    {

        $readonly = $this->isReadonly() ? 'readonly' : '';
        $disabled = $this->isDisabled() ? 'disabled' : '';
        $autofocus = $this->isAutofocus() ? 'autofocus' : '';
        $dir = !empty($this->getDir()) ? 'dir="' . $this->getDir() . '"' : '';
        $dirname = !empty($this->getDir()) ? 'dirname="' . $this->getId() . '.dir"' : '';
        $maxlength = $this->getMaxlength() ? 'maxlength="' . $this->getMaxlength() . '"' : '';
        $placeholder = $this->getPlaceholder() ? 'placeholder="' . $this->getPlaceholder() . '"' : '';
        $wrap = $this->getWrap() ? 'wrap="' . $this->getWrap() . '"' : '';

        $output = <<<HTML
            <textarea 
                id="{$this->getId()}"
                name="{$this->getId()}"
                rows="{$this->getRows()}"
                cols="{$this->getCols()}"
                $readonly
                $disabled
                $autofocus
                $maxlength
                $placeholder
                $dir
                $dirname
                $wrap
                >$currentValue</textarea>
        HTML;

        return $output;
    }
}
