<?php

namespace Rockschtar\WordPress\Settings\Fields;

use Rockschtar\WordPress\Settings\Traits\DisabledTrait;

use function in_array;
use function is_array;

class UploadMedia extends Field
{
    use DisabledTrait;

    private string $uploadButtonText = 'Upload';

    private string $removeButtonText = 'Remove';

    public function output($currentValue, array $args = []): string
    {
        $fieldId = $this->getId();

        $mediaUrl = $attachmentId = $thumbUrl = $iconUrl = '';

        if (is_array($currentValue)) {
            $attachmentId = $currentValue['attachment_id'] ?? '';

            if (!empty($attachmentId)) {
                $mediaUrl = $currentValue['media_url'] ?? '';
                $iconUrl = $currentValue['icon_url'] ?? '';
                $mimeType = get_post_mime_type($attachmentId) === false ? '' : get_post_mime_type($attachmentId);
                $thumbUrl = $this->mimeTypeIsImage($mimeType) ? $mediaUrl : $iconUrl;
            }
        };

        $displayNone = empty($thumbUrl) ? 'display: none;' : '';
        return <<<HTML
            <img style="max-height: 64px; max-width: 64px; {$displayNone}" alt="" src="{$thumbUrl}" id="{$fieldId}_thumb" />
            <input type="hidden" name="{$fieldId}[media_url]" id="$fieldId" value="$mediaUrl" />
            <input type="hidden" name="{$fieldId}[attachment_id]" id="{$fieldId}_attachment_id" value="{$attachmentId}" />
            <input type="hidden" name="{$fieldId}[icon_url]" id="{$fieldId}_attachment_icon" value="{$iconUrl}" />
            <input 
                style="vertical-align: bottom;" 
                data-fieldid="{$fieldId}" {$this->isDisabled()} 
                class="button button-secondary rwps_button_add_media" 
                name="{$fieldId}_button_add" 
                type="button" 
                value="{$this->getUploadButtonText()}" 
            />
            <input 
                style="vertical-align: bottom;{$displayNone}" 
                data-fieldid="{$fieldId}" 
                class="button button-secondary rwps_button_remove_media" 
                name="{$fieldId}_button_remove" 
                id="{$fieldId}_button_remove" 
                type="button" 
                value="{$this->getRemoveButtonText()}" 
            />
        HTML;
    }


    private function mimeTypeIsImage(string $mimeType): bool
    {
        $imageMimeTypes = [
            'image/bmp',
            'image/gif',
            'image/jpeg',
            'image/png',
            'image/svg+xml',
            'image/x-icon',
        ];

        return in_array($mimeType, $imageMimeTypes, false);
    }

    /**
     * @return string
     */
    public function getUploadButtonText(): string
    {
        return $this->uploadButtonText;
    }

    /**
     * @param string $uploadButtonText
     * @return UploadMedia
     */
    public function setUploadButtonText(string $uploadButtonText): UploadMedia
    {
        $this->uploadButtonText = $uploadButtonText;
        return $this;
    }

    /**
     * @return string
     */
    public function getRemoveButtonText(): string
    {
        return $this->removeButtonText;
    }

    /**
     * @param string $removeButtonText
     * @return UploadMedia
     */
    public function setRemoveButtonText(string $removeButtonText): UploadMedia
    {
        $this->removeButtonText = $removeButtonText;
        return $this;
    }
}
