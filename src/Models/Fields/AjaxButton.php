<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Models\Fields;


use PHP_CodeSniffer\Standards\Generic\Sniffs\Functions\FunctionCallArgumentSpacingSniff;
use Rockschtar\WordPress\Settings\Models\Field;

class AjaxButton extends Field {

    /**
     * @var String|null
     */
    private $wait_text = 'Please wait';

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
    public function getWaitText(): ?String {
        return $this->wait_text;
    }

    /**
     * @param String|null $wait_text
     * @return AjaxButton
     */
    public function setWaitText(?String $wait_text): AjaxButton {
        $this->wait_text = $wait_text;
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


}