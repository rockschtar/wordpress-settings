<?php


namespace Rockschtar\WordPress\Settings\Fields;


use Rockschtar\WordPress\Settings\Models\AssetScript;
use Rockschtar\WordPress\Settings\Models\Field;
use Rockschtar\WordPress\Settings\Traits\AutofocusTrait;
use Rockschtar\WordPress\Settings\Traits\DisabledTrait;

class FileUpload extends Field {

    use AutofocusTrait;

    use DisabledTrait;

    /**
     * @var string|null
     */
    private $uploadDirectory;

    /**
     * @var string|null
     */
    private $uploadUrl;

    public function __construct($id) {

        $ajax_button_asset_script = new AssetScript('rwps-file-upload', admin_url('?action=rwps-load-script&script=FileUpload.js'), false, ['jquery']);
        $this->addAsset($ajax_button_asset_script);
        parent::__construct($id);
    }


    /**
     * @param $current_value
     * @param array $args
     * @return string
     */
    public function inputHTML($current_value, array $args = []): string {

        $fieldId = $this->getId();
        $filename = '';
        $url = '';
        $html = '';
        if (is_array($current_value) && array_key_exists('file', $current_value) && array_key_exists('url', $current_value)) {
            $filename = basename($current_value['file']);
            $url = $current_value['url'];
            $html = '<a id="' . $fieldId . '-file-link" href="' . $url . '">' . $filename . '</a>&nbsp;<a href="#" class="error-message rwps-file-upload-delete" data-field-id="' . $fieldId . '">X</a>';
        }

        $html .= '<input type="hidden" id="' . $fieldId . '" name="' . $fieldId . '" value="' . $filename . '" />';
        $html .= '<br /><input type="file" id="' . $fieldId . '-file-upload" name="' . $fieldId . '-file-upload" />';

        return $html;
    }

    /**
     * @return string|null
     */
    public function getUploadDirectory(): ?string {
        return $this->uploadDirectory;
    }

    /**
     * @param string $uploadDirectory
     */
    public function setUploadDirectory(string $uploadDirectory): void {
        $this->uploadDirectory = $uploadDirectory;
    }

    /**
     * @return string|null
     */
    public function getUploadUrl(): ?string {
        return $this->uploadUrl;
    }

    /**
     * @param string|null $uploadUrl
     */
    public function setUploadUrl(?string $uploadUrl): void {
        $this->uploadUrl = $uploadUrl;
    }
}