<?php


namespace Rockschtar\WordPress\Settings\Fields;


use Rockschtar\WordPress\Settings\Models\AssetScript;
use Rockschtar\WordPress\Settings\Models\Field;
use Rockschtar\WordPress\Settings\Models\HTMLTag;
use Rockschtar\WordPress\Settings\Traits\AutofocusTrait;
use Rockschtar\WordPress\Settings\Traits\DisabledTrait;
use Rockschtar\WordPress\Settings\Traits\ReadOnlyTrait;

class FileUpload extends Field {

    use AutofocusTrait;

    use DisabledTrait;

    use ReadOnlyTrait;


    /**
     * @var array
     */
    private $allowedMimeTypes = [];

    private $appendMimeTypes = true;

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
        $html = '';

        if (is_array($current_value) && array_key_exists('file', $current_value) && array_key_exists('url', $current_value)) {
            $filename = basename($current_value['file']);
            $url = $current_value['url'];
            $html = '<a id="' . $fieldId . '-file-link" href="' . $url . '">' . $filename . '</a>&nbsp;<a href="#" class="error-message rwps-file-upload-delete" data-field-id="' . $fieldId . '">X</a><br />';
        }

        $html .= '<input type="hidden" id="' . $fieldId . '" name="' . $fieldId . '" value="' . $filename . '" />';

        $html_tag = new HTMLTag('input');
        $html_tag->setAttribute('type', 'file');

        $html_tag->setAttribute('id', $this->getId() . '-file-upload');
        $html_tag->setAttribute('name', $this->getId() . '-file-upload');

        if ($this->isReadonly()) {
            $html_tag->setAttribute('readonly');
        }

        if ($this->isDisabled()) {
            $html_tag->setAttribute('disabled');
        }

        if ($this->isAutofocus()) {
            $html_tag->setAttribute('autofocus');
        }


        return $html . $html_tag->buildTag();


    }

    /**
     * @return string|null
     */
    public function getUploadDirectory(): ?string {
        return $this->uploadDirectory;
    }

    /**
     * @param string $uploadDirectory
     * @return FileUpload
     */
    public function setUploadDirectory(string $uploadDirectory): FileUpload {
        $this->uploadDirectory = $uploadDirectory;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUploadUrl(): ?string {
        return $this->uploadUrl;
    }

    /**
     * @param string|null $uploadUrl
     * @return FileUpload
     */
    public function setUploadUrl(?string $uploadUrl): FileUpload {
        $this->uploadUrl = $uploadUrl;
        return $this;
    }

    /**
     * @return array
     */
    public function getAllowedMimeTypes(): array {
        return $this->allowedMimeTypes;
    }


    public function addAllowedMimeType(string $key, string $mimeType): FileUpload {
        $this->allowedMimeTypes[$key] = $mimeType;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAppendMimeTypes(): bool {
        return $this->appendMimeTypes;
    }

    /**
     * @param bool $appendMimeTypes
     */
    public function setAppendMimeTypes(bool $appendMimeTypes): FileUpload {
        $this->appendMimeTypes = $appendMimeTypes;
        return $this;
    }




}