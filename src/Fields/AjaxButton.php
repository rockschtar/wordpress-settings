<?php

namespace Rockschtar\WordPress\Settings\Fields;

use Rockschtar\WordPress\Settings\Enqueue\EnqueueScript;
use Rockschtar\WordPress\Settings\Traits\DisabledTrait;

class AjaxButton extends Button
{
    use DisabledTrait;

    private ?string $labelWait = 'Please wait';

    private ?string $labelSuccess = null;

    private ?string $labelError = null;

    private ?string $jsCallbackSuccess = null;

    private ?string $js_callback_error = null;

    private ?string $js_callback_done = null;

    public function __construct(string $id)
    {
        parent::__construct($id);

        $asset = include RWPS_PLUGIN_DIR . '/dist/wp/AjaxButton.asset.php';
        $assetScript = EnqueueScript::create('rwps-ajax-button')
            ->setSrc(RWPS_PLUGIN_URL . '/dist/wp/AjaxButton.js')
            ->setVer($asset['version'])
            ->setDeps($asset['dependencies'])
            ->addLocalize('rwps_ajax_button', ['nonce' => wp_create_nonce('rwps-ajax-button-nonce')]);

        $this->addEnqueue($assetScript);
    }


    public function output($currentValue, array $args = []): string
    {
        $disabled = $this->isDisabled() ? 'disabled' : '';

        return <<<HTML
            <button type="button" id="{$this->getId()}"
                    $disabled
                    data-wait-text="{$this->getButtonlabelWait()}"
                    data-label-success="{$this->getLabelSuccess()}"
                    data-label-error="{$this->getLabelError()}"
                    data-callback-success="{$this->getJSCallbackSuccess()}"
                    data-callback-error="{$this->getJSCallbackError()}"
                    data-callback-done="{$this->getJSCallbackDone()}"
                    class="button button-secondary rwps-ajax-button rwps-ajax-button-{$this->getId()}">{$this->getButtonLabel()}
            </button>
        HTML;
    }

    public function getButtonlabelWait(): ?string
    {
        return $this->labelWait;
    }

    public function setButtonlabelWait(?string $label): AjaxButton
    {
        $this->labelWait = $label;
        return $this;
    }

    public function getLabelSuccess(): ?string
    {
        return $this->labelSuccess;
    }

    public function setLabelSuccess(?string $labelSuccess): AjaxButton
    {
        $this->labelSuccess = $labelSuccess;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLabelError(): ?string
    {
        return $this->labelError;
    }

    /**
     * @param string|null $labelError
     * @return AjaxButton
     */
    public function setLabelError(?string $labelError): AjaxButton
    {
        $this->labelError = $labelError;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getJSCallbackSuccess(): ?string
    {
        return $this->jsCallbackSuccess;
    }

    /**
     * @param string|null $jsCallbackSuccess
     * @return AjaxButton
     */
    public function setJSCallbackSuccess(?string $jsCallbackSuccess): AjaxButton
    {
        $this->jsCallbackSuccess = $jsCallbackSuccess;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getJSCallbackError(): ?string
    {
        return $this->js_callback_error;
    }

    /**
     * @param string|null $js_callback_error
     * @return AjaxButton
     */
    public function setJSCallbackError(?string $js_callback_error): AjaxButton
    {
        $this->js_callback_error = $js_callback_error;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getJSCallbackDone(): ?string
    {
        return $this->js_callback_done;
    }

    /**
     * @param string|null $js_callback_done
     * @return AjaxButton
     */
    public function setJSCallbackDone(?string $js_callback_done): AjaxButton
    {
        $this->js_callback_done = $js_callback_done;
        return $this;
    }
}
