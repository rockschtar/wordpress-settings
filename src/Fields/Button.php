<?php

namespace Rockschtar\WordPress\Settings\Fields;

abstract class Button extends Field
{
    public const POSITION_FORM = 'form';
    public const POSITION_BEFORE_SUBMIT = 'before_submit';
    public const POSITION_AFTER_SUBMIT = 'after_submit';

    private ?string $position = self::POSITION_FORM;

    private string $buttonLabel = '';

    private string $action = '';

    /**
     * @var callable
     */
    private $callable;


    public function getCallable(): callable
    {
        return $this->callable;
    }

    public function setCallable(callable $callable): static
    {
        $this->callable = $callable;
        return $this;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function setAction(string $action): static
    {
        $this->action = $action;
        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): static
    {
        $this->position = $position;
        return $this;
    }

    public function output($currentValue, array $args = []): string
    {
        return <<<HTML
            <button 
                type="button" 
                id="{$this->getId()}"
                class="button 
                button-secondary rwps-ajax-button rwps-ajax-button-{$this->getId()}">{$this->getButtonLabel()}
            </button>
        HTML;
    }

    public function getButtonLabel(): string
    {
        if (empty($this->buttonLabel)) {
            return $this->getId();
        }

        return $this->buttonLabel;
    }

    public function setButtonLabel(string $buttonLabel): static
    {
        $this->buttonLabel = $buttonLabel;
        return $this;
    }
}
