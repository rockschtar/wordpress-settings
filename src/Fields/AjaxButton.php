<?php

namespace Rockschtar\WordPress\Settings\Fields;

use Rockschtar\WordPress\Settings\Models\AssetScript;
use Rockschtar\WordPress\Settings\Models\Button;
use Rockschtar\WordPress\Settings\Traits\DisabledTrait;

/**
 * Class AjaxButton
 * @package Rockschtar\WordPress\Settings
 */
class AjaxButton extends Button {

    use DisabledTrait;

    /**
     * @var String|null
     */
    private $button_label_wait = 'Please wait';

    /**
     * @var string|null
     */
    private $button_label_success;


    /**
     * @var string|null
     */
    private $button_label_error;

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

    public function __construct($id) {
        parent::__construct($id);
        $ajax_button_asset_script = new AssetScript('rwps-ajax-button', admin_url('?action=rwps-load-script&script=AjaxButton.js'), false, ['jquery']);
        $ajax_button_asset_script->addLocalize('rwps_ajax_button', ['nonce' => wp_create_nonce('rwps-ajax-button-nonce')]);
        $this->addAsset($ajax_button_asset_script);
    }


    /**
     * @param mixed $current_value
     * @param array $args
     * @return string
     */
    public function inputHTML($current_value, array $args = []): string {
        ob_start();
        ?>
        <button <?php disabled($this->isDisabled()); ?> type="button" id="<?php echo $this->getId(); ?>"
                                                        data-wait-text="<?php echo $this->getButtonlabelWait(); ?>"
                                                        data-label-success="<?php echo $this->getButtonLabelSuccess(); ?>"
                                                        data-label-error="<?php echo $this->getButtonLabelError(); ?>"
                                                        data-callback-success="<?php echo $this->getJSCallbackSuccess(); ?>"
                                                        data-callback-error="<?php echo $this->getJSCallbackError(); ?>"
                                                        data-callback-done="<?php echo $this->getJSCallbackDone(); ?>"
                                                        class="button button-secondary rwps-ajax-button rwps-ajax-button-<?php $this->getId(); ?>"><?php echo $this->getButtonLabel(); ?></button>
        <?php

        return ob_get_clean();

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