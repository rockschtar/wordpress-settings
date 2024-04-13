<?php

namespace Rockschtar\WordPress\Settings\Fields;

use Rockschtar\WordPress\Settings\Enqueue\EnqueueScript;
use Rockschtar\WordPress\Settings\Traits\AutofocusTrait;
use Rockschtar\WordPress\Settings\Traits\DisabledTrait;
use Rockschtar\WordPress\Settings\Traits\ReadOnlyTrait;
use Rockschtar\WordPress\Settings\Utils\PathUtil;

class UploadFile extends Field
{
    use AutofocusTrait;

    use DisabledTrait;

    use ReadOnlyTrait;

    private array $allowedMimeTypes = [];

    private bool $appendMimeTypes = true;

    private ?string $uploadDirectory = null;

    private ?string $uploadUrl = null;

    public function __construct($id)
    {
        $enqueueSrcPath = RWPS_PLUGIN_DIR . '/dist/wp/UploadFile.js';
        $asset = include RWPS_PLUGIN_DIR . 'dist/wp/UploadFile.asset.php';

        if (PathUtil::isPublicPath($enqueueSrcPath)) {
            $src = RWPS_PLUGIN_URL . '/dist/wp/UploadFile.js';
        } else {
            $src = admin_url('?action=rwps-load-script&script=UploadFile.js');
        }

        $enqueue = new EnqueueScript('rwps-upload-file', $src, $asset['version'], $asset['dependencies']);

        $this->addEnqueue($enqueue);
        parent::__construct($id);
    }

    public function output($currentValue, array $args = []): string
    {

        $fieldId = $this->getId();
        $filename = '';
        $htmlFileLink = '';
        $readonly = $this->isReadonly() ? 'readonly' : '';
        $disabled = $this->isDisabled() ? 'disabled' : '';
        $autofocus = $this->isAutofocus() ? 'autofocus' : '';

        if (is_array($currentValue) && array_key_exists('file', $currentValue) && array_key_exists('url', $currentValue)) {
            $filename = basename($currentValue['file']);
            $url = $currentValue['url'];
            $htmlFileLink = <<<HTML
                <a id="{$this->getId()}-file-link" href="$url">$filename</a>&nbsp;
                <a href="#" class="error-message rwps-file-upload-delete" data-field-id="$fieldId">X</a><br />
            HTML;
        }

        return <<<HTML
            $htmlFileLink
            <input type="hidden" id="{$this->getId()}" name="{$this->getId()}" value="$filename" />
            <input 
                type="file" 
                id="{$this->getId()}-file-upload" 
                name="{$this->getId()}-file-upload" 
                $readonly
                $disabled
                $autofocus
            />
        HTML;
    }

    public function getUploadDirectory(): ?string
    {
        return $this->uploadDirectory;
    }

    public function setUploadDirectory(string $uploadDirectory): UploadFile
    {
        $this->uploadDirectory = $uploadDirectory;
        return $this;
    }

    public function getUploadUrl(): ?string
    {
        return $this->uploadUrl;
    }

    public function setUploadUrl(?string $uploadUrl): UploadFile
    {
        $this->uploadUrl = $uploadUrl;
        return $this;
    }

    public function getAllowedMimeTypes(): array
    {
        return $this->allowedMimeTypes;
    }

    public function addAllowedMimeType(string $key, string $mimeType): UploadFile
    {
        $this->allowedMimeTypes[$key] = $mimeType;
        return $this;
    }

    public function isAppendMimeTypes(): bool
    {
        return $this->appendMimeTypes;
    }

    public function setAppendMimeTypes(bool $appendMimeTypes): UploadFile
    {
        $this->appendMimeTypes = $appendMimeTypes;
        return $this;
    }
}
