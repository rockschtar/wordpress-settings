<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Models\Fields;

use Rockschtar\WordPress\Settings\Models\Field;

class AjaxButton extends Field {

    /**
     * @var String|null
     */
    private $button_label_wait = 'Please wait';

    /**
     * @var string
     */
    private $button_label;


    /**
     * @var string|null
     */
    private $button_label_success;


    /**
     * @var string|null
     */
    private $button_label_error;


    /**
     * @var String
     */
    private $action;

    /**
     * @var callable
     */
    private $function;

    /**
     * @var string|null
     */
    private $js_callback_success;

    /**
     * @var string|null
     */
    private $js_callback_error;

    /**
     * @var string|null
     */
    private $js_callback_done;


    /**
     * @return callable
     */
    public function getFunction(): callable {
        return $this->function;

    }

    /**
     * @param callable $function
     * @return AjaxButton
     */
    public function setFunction(callable $function): AjaxButton {
        $this->function = $function;
        return $this;
    }

    /**
     * @return String
     */
    public function getAction(): String {
        return $this->action;
    }

    /**
     * @param String $action
     * @return AjaxButton
     */
    public function setAction(String $action): AjaxButton {
        $this->action = $action;
        return $this;
    }

    /**
     * @return string
     */
    public function getButtonLabel(): string {
        return $this->button_label;
    }

    /**
     * @param string $button_label
     * @return AjaxButton
     */
    public function setButtonLabel(string $button_label): AjaxButton {
        $this->button_label = $button_label;
        return $this;
    }

    /**
     * @return String|null
     */
    public function getButtonlabelWait(): ?String {
        return $this->button_label_wait;
    }

    /**
     * @param String|null $button_label_wait
     * @return AjaxButton
     */
    public function setButtonlabelWait(?String $button_label_wait): AjaxButton {
        $this->button_label_wait = $button_label_wait;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getButtonLabelSuccess(): ?string {
        return $this->button_label_success;
    }

    /**
     * @param string|null $button_label_success
     * @return AjaxButton
     */
    public function setButtonLabelSuccess(?string $button_label_success): AjaxButton {
        $this->button_label_success = $button_label_success;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getButtonLabelError(): ?string {
        return $this->button_label_error;
    }

    /**
     * @param string|null $button_label_error
     * @return AjaxButton
     */
    public function setButtonLabelError(?string $button_label_error): AjaxButton {
        $this->button_label_error = $button_label_error;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getJSCallbackSuccess(): ?string {
        return $this->js_callback_success;
    }

    /**
     * @param string|null $js_callback_success
     * @return AjaxButton
     */
    public function setJSCallbackSuccess(?string $js_callback_success): AjaxButton {
        $this->js_callback_success = $js_callback_success;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getJSCallbackError(): ?string {
        return $this->js_callback_error;
    }

    /**
     * @param string|null $js_callback_error
     * @return AjaxButton
     */
    public function setJSCallbackError(?string $js_callback_error): AjaxButton {
        $this->js_callback_error = $js_callback_error;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getJSCallbackDone(): ?string {
        return $this->js_callback_done;
    }

    /**
     * @param string|null $js_callback_done
     * @return AjaxButton
     */
    public function setJSCallbackDone(?string $js_callback_done): AjaxButton {
        $this->js_callback_done = $js_callback_done;
        return $this;
    }
}