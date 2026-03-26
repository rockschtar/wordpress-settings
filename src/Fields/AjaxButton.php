<?php

namespace Rockschtar\WordPress\Settings\Fields;

use Rockschtar\WordPress\Settings\Enqueue\EnqueueScript;
use Rockschtar\WordPress\Settings\Traits\DisabledTrait;
use Rockschtar\WordPress\Settings\Utils\PathUtil;
use Rockschtar\WordPress\Settings\Utils\PluginVersion;

class AjaxButton extends Button
{
    use DisabledTrait;

    private ?string $labelWait = 'Please wait';

    private ?string $labelSuccess = null;

    private ?string $labelError = null;

    private ?string $jsCallbackSuccess = null;

    private ?string $jsCallbackError = null;

    private ?string $jsCallbackDone = null;

    public function __construct(string $id)
    {
        parent::__construct($id);

        $enqueueSrcPath = RWPS_PLUGIN_DIR . '/js/AjaxButton.js';

        if (PathUtil::isPublicPath($enqueueSrcPath)) {
            $src = RWPS_PLUGIN_URL . '/js/AjaxButton.js';
        } else {
            $src = admin_url('?action=rwps-load-script&script=AjaxButton.js');
        }

        $enqueue = new EnqueueScript('rwps-ajax-button', $src, PluginVersion::get(), ['jquery']);
        $enqueue->addLocalize('rwps_ajax_button', ['nonce' => wp_create_nonce('rwps-ajax-button-nonce')]);

        $this->addEnqueue($enqueue);
    }


    #[\Override]
    public function output($currentValue, array $args = []): string
    {
        $id           = esc_attr($this->getId());
        $disabled     = $this->isDisabled() ? 'disabled' : '';
        $labelWait    = esc_attr($this->getLabelWait());
        $labelSuccess = esc_attr($this->getLabelSuccess());
        $labelError   = esc_attr($this->getLabelError());
        $cbSuccess    = esc_attr($this->getJSCallbackSuccess());
        $cbError      = esc_attr($this->getJSCallbackError());
        $cbDone       = esc_attr($this->getJSCallbackDone());
        $buttonLabel  = esc_html($this->getButtonLabel());

        return <<<HTML
            <button type="button" id="$id"
                    $disabled
                    data-wait-text="$labelWait"
                    data-label-success="$labelSuccess"
                    data-label-error="$labelError"
                    data-callback-success="$cbSuccess"
                    data-callback-error="$cbError"
                    data-callback-done="$cbDone"
                    class="button button-secondary rwps-ajax-button rwps-ajax-button-$id">$buttonLabel
            </button>
        HTML;
    }

    public function getLabelWait(): ?string
    {
        return $this->labelWait;
    }

    public function setLabelWait(?string $label): AjaxButton
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

    public function getLabelError(): ?string
    {
        return $this->labelError;
    }

    public function setLabelError(?string $labelError): AjaxButton
    {
        $this->labelError = $labelError;
        return $this;
    }

    public function getJSCallbackSuccess(): ?string
    {
        return $this->jsCallbackSuccess;
    }

    public function setJSCallbackSuccess(?string $jsCallbackSuccess): AjaxButton
    {
        $this->jsCallbackSuccess = $jsCallbackSuccess;
        return $this;
    }

    public function getJSCallbackError(): ?string
    {
        return $this->jsCallbackError;
    }

    public function setJSCallbackError(?string $jsCallbackError): AjaxButton
    {
        $this->jsCallbackError = $jsCallbackError;
        return $this;
    }

    public function getJSCallbackDone(): ?string
    {
        return $this->jsCallbackDone;
    }

    public function setJSCallbackDone(?string $jsCallbackDone): AjaxButton
    {
        $this->jsCallbackDone = $jsCallbackDone;
        return $this;
    }
}
