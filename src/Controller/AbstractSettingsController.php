<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Controller;

use Rockschtar\WordPress\Settings\Enum\FieldType;
use Rockschtar\WordPress\Settings\Models\Checkbox;
use Rockschtar\WordPress\Settings\Models\CheckboxList;
use Rockschtar\WordPress\Settings\Models\Field;
use Rockschtar\WordPress\Settings\Models\Media;
use Rockschtar\WordPress\Settings\Models\Page;
use Rockschtar\WordPress\Settings\Models\Section;
use Rockschtar\WordPress\Settings\Models\SelectBox;
use Rockschtar\WordPress\Settings\Models\Textfield;
use Rockschtar\WordPress\Settings\Models\Upload;

abstract class AbstractSettingsController {

    public function __construct() {
        add_action('admin_menu', array($this, 'create_settings'));
        add_action('admin_init', array($this, 'setup_sections'));
        add_action('admin_init', array($this, 'setup_fields'));

        foreach ($this->getPage()->getSections() as $section) {

            foreach ($section->getFields() as $field) {
                if (is_a($field, Upload::class)) {
                    add_action('admin_footer', array($this, 'media_fields'));
                    add_action('admin_enqueue_scripts', 'wp_enqueue_media');
                }
            }

        }

    }

    final public function create_settings(): void {
        $page = $this->getPage();
        $callback = $page->getCallback() ?? array($this, 'settings_content');
        add_menu_page($page->getPageTitle(), $page->getMenuTitle(), $page->getCapability(), $page->getId(), $callback, $page->getIcon(), $page->getPosition());
    }

    final public function setup_sections(): void {
        foreach ($this->getPage()->getSections() as $section) {
            add_settings_section($section->getId(), $section->getTitle(), $section->getCallback(), $this->getPage()->getId());
        }
    }

    final public function setup_fields(): void {
        foreach ($this->getPage()->getSections() as $section) {
            foreach ($section->getFields() as $field) {
                add_settings_field($field->getId(), $field->getLabel(), array($this, 'field'), $this->getPage()->getId(), $section->getId(), ['field' => $field]);
                $arguments = $field->getArguments();

                if (is_a($field, Upload::class)) {

                    $sanitize_callback = function ($value) use ($arguments) {
                        if (!is_array($value)) {
                            $value = '';
                        } else {
                            if (isset($value['attachment_id']) && empty($value['attachment_id'])) {
                                $value = '';
                            }
                        }

                        if (array_key_exists('sanitize_callback', $arguments)) {
                            $user_sanitize_callback = $arguments['sanitize_callback'];
                            $value = call_user_func($user_sanitize_callback, $value);
                        }

                        return $value;
                    };

                    $arguments['sanitize_callback'] = $sanitize_callback;

                }

                register_setting($this->getPage()->getId(), $field->getId(), $arguments);
            }
        }
    }

    /**
     * @return Section[]
     */
    abstract public function getSections(): array;

    abstract public function getPage(): Page;

    public function settings_content(): void { ?>
        <div class="wrap">
            <h1>Custom Settings Page</h1>
            <?php settings_errors(); ?>
            <form method="POST" action="options.php">
                <?php
                settings_fields($this->getPage()->getId());
                do_settings_sections($this->getPage()->getId());
                submit_button();
                ?>
            </form>
        </div> <?php
    }

    public function field(array $args): void {
        /* @var Field $field ; */
        $field = $args['field'];

        $current_field_value = get_option($field->getId());

        switch (\get_class($field)) {
            case Textfield::class:
                /* @var Textfield $field ; */
                printf('<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $field->getId(), $field->getType(), $field->getPlaceholder(), $current_field_value);
                break;
            case Checkbox::class:
                /* @var Checkbox $field ; */
                $checked = checked($field->getValue(), $current_field_value, false);
                printf('<input name="%1$s" id="%1$s" type="%2$s" %3$s value="%4$s" />', $field->getId(), 'checkbox', $checked, $field->getValue());
                break;
            case SelectBox::class:
                /* @var SelectBox $field ; */
                $attr = '';
                $options = '';

                foreach ($field->getItems() as $item) {
                    $selected = false;

                    foreach ($current_field_value as $current_value) {
                        $selected = selected($item->getValue(), $current_value, false);

                        if ($selected) {
                            break;
                        }
                    }

                    $options .= sprintf('<option value="%s" %s>%s</option>', $item->getValue(), $selected, $item->getLabel());
                }

                if ($field->isMultiselect()) {
                    $attr = ' multiple="multiple" ';
                }
                printf('<select name="%1$s[]" id="%1$s" %2$s>%3$s</select>', $field->getId(), $attr, $options);

                break;
            case CheckboxList::class:
                /* @var CheckboxList $field ; */
                $options_markup = '';
                $iterator = 0;

                foreach ($field->getItems() as $item) {
                    $iterator++;
                    $checked = false;
                    foreach ($current_field_value as $current_value) {
                        if ($item->getValue() === $current_value) {
                            $checked = checked(true, true, false);
                            break;
                        }
                    }

                    $options_markup .= sprintf('<label for="%1$s_%6$s"><input id="%1$s_%6$s" name="%1$s[]" type="%2$s" value="%3$s" %4$s /> %5$s</label><br/>', $field->getId(), 'checkbox', $item->getValue(), $checked, $item->getLabel(), $iterator);
                }
                printf('<fieldset>%s</fieldset>', $options_markup);

                break;
            case Upload::class;
                /* @var Upload $field ; */
                $field_id = $field->getId();

                $media_url = $attachment_id = $icon_url = '';

                if (is_array($current_field_value)) {
                    $attachment_id = isset($current_field_value['attachment_id']) ? $current_field_value['attachment_id'] : '';

                    if (!empty($attachment_id)) {
                        $media_url = isset($current_field_value['media_url']) ? $current_field_value['media_url'] : '';
                        $icon_url = isset($current_field_value['icon_url']) ? $current_field_value['icon_url'] : '';
                        $thumb_url = $this->mimeTypeIsImage(get_post_mime_type($attachment_id)) ? $media_url : $icon_url;
                    }
                }
                ?>
                <img style="max-height: 64px; max-width: 64px;" src="<?php echo $thumb_url; ?>" id="<?php echo $field_id ?>_thumb"/>
                <input type="text" name="<?php echo $field_id; ?>[media_url]" id="<?php echo $field_id; ?>" value="<?php echo $media_url; ?>">
                <input type="text" name="<?php echo $field_id; ?>[attachment_id]" id="<?php echo $field_id; ?>_attachment_id" value="<?php echo $attachment_id ?>">
                <input type="text" name="<?php echo $field_id; ?>[icon_url]" id="<?php echo $field_id; ?>_attachment_icon" value="<?php echo $icon_url; ?>">
                <input data-fieldid="<?php echo $field_id; ?>" class="button button-secondary rwps_button_add_media" name="<?php echo $field_id; ?>_button_add" type="button"
                       value="<?php echo $field->getUploadButtonText(); ?>"/>
                <input data-fieldid="<?php echo $field_id; ?>" class="button button-secondary rwps_button_remove_media" name="<?php echo $field_id; ?>_button_remove"
                       type="button"
                       value="<?php echo $field->getRemoveButtonText(); ?>"/>
                <?php
                break;
            case FieldType::WYSIWYG:
            default:
                echo 'Unknown field type';
        }

        printf('<p class="description">%s </p>', $field->getDescription());
    }

    final public function media_fields(): void {
        ?>
        <script>
            jQuery(document).ready(function ($) {

                var RWPSMediaUpload = (function () {

                    var page_id = '<?php echo $this->getPage()->getId(); ?>';

                    function init() {
                        wp.media.UploadIt = {
                            frame: function (buttonSender) {

                                if (this._frame)
                                    return this._frame;

                                var that = this;

                                this._frame = wp.media({
                                    id: 'rwps-media-frame',
                                    title: 'Upload Title',
                                    editing: true,
                                    multiple: false,
                                });
                                this._frame.on("select", function () {
                                        var attachment = that._frame.state().get('selection').first().toJSON();
                                        onSelectMedia(buttonSender, attachment);
                                    }
                                );
                                return this._frame;
                            },
                            init: function () {

                            }
                        };

                        $('.rwps_button_add_media').bind('click', function (event) {
                            event.preventDefault();
                            wp.media.UploadIt.frame($(this)).open();
                        });

                        $('.rwps_button_remove_media').bind('click', function (event) {
                            event.preventDefault();
                            onRemoveMedia($(this));
                        });
                    }

                    function getElementsFromFieldId(fieldId) {
                        var elements = [];
                        elements['imageThumbnail'] = $('#' + fieldId + '_thumb');
                        elements['inputAttachmentUrl'] = $('input#' + fieldId);
                        elements['inputAttachmentId'] = $('input#' + fieldId + '_attachment_id');
                        elements['inputAttachmentIconUrl'] = $('input#' + fieldId + '_attachment_icon');
                        return elements;
                    }

                    function onSelectMedia(buttonSender, attachment) {
                        var fieldId = buttonSender.data('fieldid');
                        elements = getElementsFromFieldId(fieldId);
                        elements['inputAttachmentId'].val(attachment.id);
                        elements['inputAttachmentUrl'].val(attachment.url);
                        elements['inputAttachmentIconUrl'].val(attachment.icon);

                        if (mimeTypeIsImage(attachment.mime) === true) {
                            elements['imageThumbnail'].attr('src', attachment.url);
                        } else {
                            elements['imageThumbnail'].attr('src', attachment.icon);
                        }
                    }

                    function onRemoveMedia(buttonSender) {
                        var fieldId = buttonSender.data('fieldid');
                        elements = getElementsFromFieldId(fieldId);
                        elements['imageThumbnail'].hide();
                        elements['imageThumbnail'].attr('src', '');
                        elements['inputAttachmentId'].val('');
                        elements['inputAttachmentUrl'].val('');
                        elements['inputAttachmentIconUrl'].val('');
                    }

                    function mimeTypeIsImage(mime_type) {
                        var image_mime_types = ['image/bmp',
                            'image/gif',
                            'image/jpeg',
                            'image/png',
                            'image/svg+xml',
                            'image/x-icon'];
                        return $.inArray(mime_type, image_mime_types) > -1;
                    }

                    return {
                        init: init
                    }

                })();


                RWPSMediaUpload.init();

            });
        </script><?php
    }

    private function mimeTypeIsImage(string $mime_type): bool {


        $image_mime_types = ['image/bmp',
                             'image/gif',
                             'image/jpeg',
                             'image/png',
                             'image/svg+xml',
                             'image/x-icon',];

        return in_array($mime_type, $image_mime_types, false);


    }
}