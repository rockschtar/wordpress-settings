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

        foreach ($this->getPage()
                      ->getSections() as $section) {

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
        foreach ($this->getPage()
                      ->getSections() as $section) {
            add_settings_section($section->getId(), $section->getTitle(), $section->getCallback(), $this->getPage()
                                                                                                        ->getId());
        }
    }

    final public function setup_fields(): void {
        foreach ($this->getPage()
                      ->getSections() as $section) {
            foreach ($section->getFields() as $field) {
                add_settings_field($field->getId(), $field->getLabel(), array($this, 'field'), $this->getPage()
                                                                                                    ->getId(), $section->getId(), ['field' => $field]);
                register_setting($this->getPage()
                                      ->getId(), $field->getId());
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
                settings_fields($this->getPage()
                                     ->getId());
                do_settings_sections($this->getPage()
                                          ->getId());
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
                printf('<input style="width: 40%%" id="%s" name="%s" type="text" value="%s"> 
                <input style="width: 19%%" class="button %s" id="%s_button" name="%s_button" type="button" value="Upload" />', $field->getId(), $field->getId(), $current_field_value, $this->getPage()
                                                                                                                                                                                                                                                                         ->getId(), $field->getId(), $field->getId());
                break;
            case FieldType::WYSIWYG:
            default:
                echo 'Unknown field type';
        }

        printf('<p class="description">%s </p>', $field->getDescription());

    }


    final public function media_fields() : void {
        ?>
        <script>
            jQuery(document).ready(function ($) {

                var page_id = '<?php echo $this->getPage()->getId(); ?>';

                if (typeof wp.media !== 'undefined') {
                    var _custom_media = true,
                        _orig_send_attachment = wp.media.editor.send.attachment;
                    $('.' + page_id).bind('click', function (e) {
                        var button = $(this);
                        var id = button.attr('id').replace('_button', '');
                        _custom_media = true;

                        wp.media.editor.send.attachment = function (props, attachment) {
                            if (_custom_media) {
                                $('input#' + id).val(attachment.url);
                            } else {
                                return _orig_send_attachment.apply(this, [props, attachment]);
                            }
                            ;
                        }
                        wp.media.editor.open(button);
                        return false;
                    });

                    $('.add_media').on('click', function () {
                        _custom_media = false;
                    });
                }
            });
        </script><?php
    }
}