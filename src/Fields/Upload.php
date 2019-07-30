<?php

namespace Rockschtar\WordPress\Settings\Fields;

use Rockschtar\WordPress\Settings\Models\Field;
use Rockschtar\WordPress\Settings\Traits\DisabledTrait;
use function in_array;
use function is_array;

/**
 * Class Upload
 * @package Rockschtar\WordPress\Settings
 */
class Upload extends Field {

    use DisabledTrait;

    /**
     * @var string
     */
    private $upload_button_text = 'Upload';

    /**
     * @var string
     */
    private $remove_button_text = 'Remove';

    /**
     * @param $current_value
     * @param array $args
     * @return string
     */
    public function inputHTML($current_value, array $args = []): string {
        ob_start();

        $field_id = $this->getId();

        $media_url = $attachment_id = $thumb_url = $icon_url = '';

        if (is_array($current_value)) {
            $attachment_id = $current_value['attachment_id'] ?? '';

            if (!empty($attachment_id)) {
                $media_url = $current_value['media_url'] ?? '';
                $icon_url = $current_value['icon_url'] ?? '';
                $mime_type = get_post_mime_type($attachment_id) === false ? '' : get_post_mime_type($attachment_id);
                $thumb_url = $this->mimeTypeIsImage($mime_type) ? $media_url : $icon_url;
            }
        }
        ?>

        <img style="max-height: 64px; max-width: 64px;<?php if (empty($thumb_url)): ?> display: none;<?php endif; ?>" alt="" src="<?php echo $thumb_url; ?>" id="<?php echo $field_id ?>_thumb"/>
        <input type="hidden" name="<?php echo $field_id; ?>[media_url]" id="<?php echo $field_id; ?>"
               value="<?php echo $media_url; ?>">
        <input type="hidden" name="<?php echo $field_id; ?>[attachment_id]"
               id="<?php echo $field_id; ?>_attachment_id"
               value="<?php echo $attachment_id ?>">
        <input type="hidden" name="<?php echo $field_id; ?>[icon_url]"
               id="<?php echo $field_id; ?>_attachment_icon"
               value="<?php echo $icon_url; ?>">
        <input style="vertical-align: bottom;" data-fieldid="<?php echo $field_id; ?>"
            <?php disabled($this->isDisabled()); ?>
               class="button button-secondary rwps_button_add_media"
               name="<?php echo $field_id; ?>_button_add"
               type="button"
               value="<?php echo $this->getUploadButtonText(); ?>"/>
        <input style="vertical-align: bottom;<?php if (empty($thumb_url)): ?> display: none;<?php endif; ?>"
               data-fieldid="<?php echo $field_id; ?>"
               class="button button-secondary rwps_button_remove_media"
               name="<?php echo $field_id; ?>_button_remove"
               id="<?php echo $field_id; ?>_button_remove"
               type="button"
               value="<?php echo $this->getRemoveButtonText(); ?>"/>

        <?php
        return ob_get_clean();


    }

    /**
     * @param string $mime_type
     * @return bool
     */
    private function mimeTypeIsImage(string $mime_type): bool {


        $image_mime_types = ['image/bmp',
                             'image/gif',
                             'image/jpeg',
                             'image/png',
                             'image/svg+xml',
                             'image/x-icon',];

        return in_array($mime_type, $image_mime_types, false);


    }

    /**
     * @return string
     */
    public function getUploadButtonText(): string {
        return $this->upload_button_text;
    }

    /**
     * @param string $upload_button_text
     * @return Upload
     */
    public function setUploadButtonText(string $upload_button_text): Upload {
        $this->upload_button_text = $upload_button_text;
        return $this;
    }

    /**
     * @return string
     */
    public function getRemoveButtonText(): string {
        return $this->remove_button_text;
    }

    /**
     * @param string $remove_button_text
     * @return Upload
     */
    public function setRemoveButtonText(string $remove_button_text): Upload {
        $this->remove_button_text = $remove_button_text;
        return $this;
    }
}