<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Controller;

use Rockschtar\WordPress\Settings\Fields\AjaxButton;
use Rockschtar\WordPress\Settings\Fields\FileUpload;
use Rockschtar\WordPress\Settings\Fields\Upload;
use Rockschtar\WordPress\Settings\Models\Asset;
use Rockschtar\WordPress\Settings\Models\AssetScript;
use Rockschtar\WordPress\Settings\Models\AssetStyle;
use Rockschtar\WordPress\Settings\Models\Field;
use Rockschtar\WordPress\Settings\Models\SettingsPage;

use function call_user_func;
use function is_array;

/**
 * Class WordPressSettings
 * @package Rockschtar\WordPress\Settings
 */
class WordPressSettings
{

    /**
     * @var SettingsPage
     */
    private $page;

    /**
     * @var string
     */
    private $hook_suffix;

    private function __construct(SettingsPage $page)
    {
        $this->page = $page;

        add_action('admin_menu', array($this, 'create_settings'));
        add_action('admin_init', array($this, 'setup_sections'));
        add_action('admin_init', array($this, 'setup_fields'));
        add_action('wp_ajax_rwps_delete_fileupload', array(&$this, 'delete_fileupload'));

        if (is_admin()) {
            $this->setup_admin_hooks();
        }

        $this->setup_global_hooks();

        $this->custom_hooks();
    }

    private function setup_admin_hooks(): void
    {
        $upload_script_added = false;

        foreach ($this->getPage()->getButtons() as $button) {
            if (is_a($button, AjaxButton::class)) {
                /* @var AjaxButton $field */
                add_action(
                  'wp_ajax_rwps_ajax_button_' . $button->getId(),
                  static function () use ($button) {
                      check_ajax_referer('rwps-ajax-button-nonce', 'nonce');
                      call_user_func($button->getCallable(), $button);
                  }
                );
            }
        }

        foreach ($this->getPage()->getSections() as $section) {
            foreach ($section->getFields() as $field) {
                add_action(
                  'update_option_' . $field->getId(),
                  static function ($old_value, $new_value) use ($field) {
                      if ($old_value !== $new_value && $field->getOnChange() !== null) {
                          call_user_func($field->getOnChange(), $field);
                      }
                  },
                  10,
                  2
                );

                if (is_a($field, FileUpload::class)) {
                    /* @var $field FileUpload */
                    $file_upload_id = $field->getId() . '-file-upload';

                    add_filter(
                      'pre_update_option_' . $field->getId(),
                      function ($value, $old_value) use ($field, $file_upload_id) {
                          if ($_FILES[$file_upload_id]['error'] === 0) {
                              $filename = $_FILES[$file_upload_id]['name'];
                              $content = file_get_contents($_FILES[$file_upload_id]['tmp_name']);

                              $this->allowedMimeTypesFilter(
                                $field,
                                static function () use ($filename, $content) {
                                    return wp_upload_bits($filename, null, $content);
                                }
                              );

                            if ($value['error']) {
                                add_settings_error($field->getId(), 1, $value['error']);
                                return $old_value;
                            }

                            if (isset($old_value['file']) && file_exists($old_value['file'])) {
                                unlink($old_value['file']);
                            }

                            return $value;

                        }

                          if (($_FILES[$file_upload_id]['error'] === UPLOAD_ERR_NO_FILE) && empty(
                            $_POST[$field->getId()]
                            ) && isset($old_value['file'])) {
                              unlink($old_value['file']);
                              return [];
                          }

                          return $old_value;
                      },
                      10,
                      2
                    );


                    add_filter(
                      'upload_dir',
                      static function ($upload_directory) use ($field, $file_upload_id) {
                          /* @var FileUpload $field */
                          if ($field->getUploadDirectory() && isset($_FILES[$file_upload_id])) {
                              $upload_directory['path'] = $field->getUploadDirectory();
                          }

                          if ($field->getUploadUrl() && isset($_FILES[$file_upload_id])) {
                              $upload_directory['url'] = $field->getUploadUrl();
                          }

                          return $upload_directory;
                      }
                    );
                }

                if ($upload_script_added === false && is_a($field, Upload::class)) {
                    add_action('admin_footer', array($this, 'media_fields'));
                    add_action('admin_enqueue_scripts', 'wp_enqueue_media');
                    $upload_script_added = true;
                }

                if (is_a($field, AjaxButton::class)) {
                    /* @var AjaxButton $field */
                    add_action(
                      'wp_ajax_rwps_ajax_button_' . $field->getId(),
                      static function () use ($field) {
                          check_ajax_referer('rwps-ajax-button-nonce', 'nonce');
                          call_user_func($field->getCallable(), $field);
                      }
                    );
                }
            }
        }
    }

    private function setup_global_hooks(): void
    {
        foreach ($this->getPage()->getSections() as $section) {
            foreach ($section->getFields() as $field) {
                if ($field->getDefaultOption() !== null) {
                    add_filter(
                      'default_option_' . $field->getId(),
                      static function ($default) use ($field) {
                          if ($default === false) {
                              $default = $field->getDefaultOption();
                          }

                          return $default;
                      },
                      10,
                      1
                    );
                }
            }
        }
    }

    final public function setup_public_hooks(): void
    {
        //setup default option here
    }

    final public function delete_fileupload(): void
    {
        $option = $_POST['option'];
        $option_value = get_option($option);
        unlink($option_value['file']);

        wp_send_json_success();
        wp_die();
    }

    /**
     * @param SettingsPage $page
     * @return WordPressSettings
     */
    public static function registerSettingsPage(SettingsPage $page): WordPressSettings
    {
        return new WordPressSettings($page);
    }


    public function custom_hooks(): void
    {
    }

    /**
     * @return SettingsPage
     */
    public function getPage(): SettingsPage
    {
        return $this->page;
    }

    final public function create_settings(): void
    {
        $page = $this->getPage();
        $callback = $page->getCallback() ?? array($this, 'settings_content');

        if ($this->getPage()->getParent() === null) {
            $this->hook_suffix = add_menu_page(
              $page->getPageTitle(),
              $page->getMenuTitle(),
              $page->getCapability(),
              $page->getId(),
              $callback,
              $page->getIcon(),
              $page->getPosition()
            );
        } else {
            $this->hook_suffix = add_submenu_page(
              $this->getPage()
                ->getParent(),
              $page->getPageTitle(),
              $page->getMenuTitle(),
              $page->getCapability(),
              $page->getId(),
              $callback
            );
        }


        if ($this->getPage()->getAdminFooterHook() !== null) {
            add_action('admin_footer-' . $this->hook_suffix, $this->getPage()->getAdminFooterHook());
        }

        add_action('admin_enqueue_scripts', array(&$this, 'admin_enqueue_scripts'));
    }

    final public function setup_sections(): void
    {
        foreach ($this->getPage()->getSections() as $section) {
            add_settings_section(
              $section->getId(),
              $section->getTitle(),
              $section->getCallback(),
              $this->getPage()
                ->getId()
            );
        }
    }

    final public function setup_fields(): void
    {
        foreach ($this->getPage()->getSections() as $section) {
            foreach ($section->getFields() as $field) {
                /* @var AjaxButton $field */
                if (is_a($field, AjaxButton::class) && $field->getPosition() !== AjaxButton::POSITION_FORM) {
                    continue;
                }

                /* @var Field $field */
                add_settings_field(
                  $field->getId(),
                  $field->getLabel(),
                  array($this, 'field'),
                  $this->getPage()
                    ->getId(),
                  $section->getId(),
                  ['field' => $field]
                );
                $arguments = $field->getSanitizeArguments();

                if (is_a($field, Upload::class)) {
                    $sanitize_callback = static function ($value) use ($field, $arguments) {
                        if (!is_array($value)) {
                            $value = '';
                        } elseif (isset($value['attachment_id']) && empty($value['attachment_id'])) {
                            $value = '';
                        }

                        if ($field->getSanitizeCallback() !== null) {
                            $user_sanitize_callback = $field->getSanitizeCallback();
                            $value = $user_sanitize_callback($value);
                        }

                        return $value;
                    };

                    $arguments['sanitize_callback'] = $sanitize_callback;
                } elseif (is_a($field, FileUpload::class)) {
                    $sanitize_callback = function ($value) use ($field, $arguments) {
                        $file_upload_id = $field->getId() . '-file-upload';

                        if ($_FILES[$file_upload_id]['error'] === 0) {
                            $mime_type = mime_content_type($_FILES[$file_upload_id]['tmp_name']);

                            $this->allowedMimeTypesFilter($field);

                            $allowed_mime_types = get_allowed_mime_types();
                            $mime_type_allowed = false;

                            foreach ($allowed_mime_types as $key => $current_mime_type) {
                                if ($current_mime_type === $mime_type) {
                                    $mime_type_allowed = true;
                                    break;
                                }
                            }

                            if ($mime_type_allowed === false) {
                                add_settings_error(
                                  $field->getId(),
                                  $field->getId(),
                                  __('Sorry, this file type is not permitted for security reasons.')
                                );
                            }
                        }

                        if ($field->getSanitizeCallback() !== null) {
                            $user_sanitize_callback = $field->getSanitizeCallback();
                            $value = $user_sanitize_callback($value);
                        }

                        return $value;
                    };

                    $arguments['sanitize_callback'] = $sanitize_callback;
                } elseif ($field->getSanitizeCallback() !== null) {
                    $arguments['sanitize_callback'] = $field->getSanitizeCallback();
                }

                register_setting($this->getPage()->getId(), $field->getId(), $arguments);
            }
        }
    }

    final public function settings_content(): void
    { ?>
        <?php
        do_action('rwps-before-page-wrap', $this->getPage()); ?>
        <?php
        do_action('rwps-before-page-wrap-' . $this->getPage()->getId()); ?>
        <div class="wrap">
            <h1><?php
                echo $this->getPage()->getPageTitle(); ?></h1>
            <?php
            if ($this->getPage()->getParent() === null) {
                settings_errors();
            }
            ?>
            <!--suppress HtmlUnknownTarget -->
            <form method="POST" action="options.php" enctype="multipart/form-data">
                <?php
                do_action('rwps-before-form-fields', $this->getPage()); ?>
                <?php
                do_action('rwps-before-form-fields' . $this->getPage()->getId()); ?>
                <?php
                settings_fields($this->getPage()->getId());
                do_settings_sections($this->getPage()->getId());

                ?>
                <p class="submit">
                    <?php
                    foreach ($this->getPage()->getButtons() as $button) {
                        if (is_a($button, AjaxButton::class) && $button->getPosition(
                          ) === AjaxButton::POSITION_BEFORE_SUBMIT) {
                            echo $button->output('');
                        }
                    } ?>

                    <input type="submit"
                           class="button-primary"
                           value="<?php
                           _e('Save Changes') ?>"
                    />
                    <?php
                    foreach ($this->getPage()->getButtons() as $button) {
                        if (is_a($button, AjaxButton::class) && $button->getPosition(
                          ) === AjaxButton::POSITION_AFTER_SUBMIT) {
                            echo $button->output('');
                        }
                    } ?>
                </p>
                <?php
                do_action('rwps-after-form-fields', $this->getPage()); ?>
                <?php
                do_action('rwps-after-form-fields' . $this->getPage()->getId()); ?>
            </form>
        </div>
        <?php
        do_action('rwps-after-page-wrap', $this->getPage());
        do_action('rwps-after-page-wrap-' . $this->getPage()->getId());
    }

    final public function field(array $args): void
    {
        /* @var Field $field ; */
        $field = $args['field'];
        $current_field_value = get_option($field->getId());
        echo $field->output($current_field_value, $args);
    }

    final public function media_fields(): void
    {
        ?>
        <script>
            jQuery(document).ready(function ($) {

                var RWPSMediaUpload = (function () {
                    function init() {

                        wp.media.RWPSUpload = {
                            frame: function (buttonSender) {

                                if (this._frame) {
                                    return this._frame;
                                }

                                var that = this;

                                this._frame = wp.media({
                                    id: 'rwps-media-frame',
                                    title: 'Upload Title',
                                    editing: true,
                                    multiple: false
                                });
                                this._frame.on("select", function () {

                                        console.log(buttonSender);
                                        console.log(buttonSender.data('fieldid'));

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
                            var frame = new wp.media.RWPSUpload.frame($(this));
                            frame.open();
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
                        elements['buttomRemove'] = $('input#' + fieldId + '_button_remove');
                        return elements;
                    }

                    function onSelectMedia(buttonSender, attachment) {
                        var fieldId = buttonSender.data('fieldid');
                        var elements = getElementsFromFieldId(fieldId);
                        elements['inputAttachmentId'].val(attachment.id);
                        elements['inputAttachmentUrl'].val(attachment.url);
                        elements['inputAttachmentIconUrl'].val(attachment.icon);
                        if (mimeTypeIsImage(attachment.mime) === true) {
                            elements['imageThumbnail'].attr('src', attachment.url);
                        } else {
                            elements['imageThumbnail'].attr('src', attachment.icon);
                        }

                        elements['buttomRemove'].show();
                        elements['imageThumbnail'].show();
                    }

                    function onRemoveMedia(buttonSender) {
                        var fieldId = buttonSender.data('fieldid');
                        var elements = getElementsFromFieldId(fieldId);
                        elements['imageThumbnail'].hide();
                        elements['imageThumbnail'].attr('src', '');
                        elements['inputAttachmentId'].val('');
                        elements['inputAttachmentUrl'].val('');
                        elements['inputAttachmentIconUrl'].val('');
                        elements['buttomRemove'].hide();
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

    /**
     * @return string
     */
    public function getHookSuffix(): string
    {
        return $this->hook_suffix;
    }


    public function enqueueAsset(Asset $asset): void
    {
        if ($asset instanceof AssetScript) {
            wp_enqueue_script(
              $asset->getHandle(),
              $asset->getSrc(),
              $asset->getDeps(),
              $asset->getVer(),
              $asset->isInFooter()
            );
            foreach ($asset->getInlines() as $inline_script) {
                wp_add_inline_script(
                  $inline_script->getHandle(),
                  $inline_script->getData(),
                  $inline_script->getPosition()
                );
            }

            if ($asset->getLocalize()) {
                wp_localize_script(
                  $asset->getHandle(),
                  $asset->getLocalize()
                    ->getObjectName(),
                  $asset->getLocalize()
                    ->getL10n()
                );
            }
        }

        if ($asset instanceof AssetStyle) {
            wp_enqueue_style(
              $asset->getHandle(),
              $asset->getSrc(),
              $asset->getDeps(),
              $asset->getVer(),
              $asset->getMedia()
            );
        }
    }

    final public function admin_enqueue_scripts($hook): void
    {
        if ($this->getHookSuffix() === $hook) {
            foreach ($this->getPage()->getSections() as $section) {
                foreach ($section->getFields() as $field) {
                    foreach ($field->getAssets() as $asset) {
                        $this->enqueueAsset($asset);
                    }
                }
            }

            foreach ($this->getPage()->getFields() as $field) {
                foreach ($field->getAssets() as $asset) {
                    $this->enqueueAsset($asset);
                }
            }

            foreach ($this->getPage()->getButtons() as $button) {
                foreach ($button->getAssets() as $asset) {
                    $this->enqueueAsset($asset);
                }
            }


            foreach ($this->getPage()->getAssets() as $asset) {
                $this->enqueueAsset($asset);
            }
        }
    }

    private function allowedMimeTypesFilter(FileUpload $field, ?\Closure $closure)
    {
        $mimeTypesFilter = static function ($mimeTypes) use ($field) {
            if ($field->isAppendMimeTypes()) {
                return array_merge($mimeTypes, $field->getAllowedMimeTypes());
            }

            return $field->getAllowedMimeTypes();
        };

        add_filter('upload_mimes', $mimeTypesFilter);

        $value = true;

        if($closure) {
            $value = $closure();
        }


        remove_filter('upload_mimes', $mimeTypesFilter);

        return $value;
    }


}