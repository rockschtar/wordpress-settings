<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Controller;

use Rockschtar\WordPress\Settings\Fields\AjaxButton;
use Rockschtar\WordPress\Settings\Fields\Upload;
use Rockschtar\WordPress\Settings\Models\AssetScript;
use Rockschtar\WordPress\Settings\Models\AssetStyle;
use Rockschtar\WordPress\Settings\Models\Field;
use Rockschtar\WordPress\Settings\Models\Page;

abstract class AbstractSettingsController {

    /**
     * @var string
     */
    private $hook_suffix;

    private function __construct() {
        add_action('admin_menu', array($this, 'create_settings'));
        add_action('admin_init', array($this, 'setup_sections'));
        add_action('admin_init', array($this, 'setup_fields'));

        $ajax_button_script_added = false;
        $upload_script_added = false;

        foreach ($this->getPage()->getButtons() as $button) {
            if ($ajax_button_script_added === false && is_a($button, AjaxButton::class)) {
                add_action('admin_footer', array(&$this, 'ajax_button_script'));
                $ajax_button_script_added = true;
            }

            if (is_a($button, AjaxButton::class)) {
                /* @var AjaxButton $field */
                add_action('wp_ajax_rwps_ajax_button_' . $button->getId(), function () use ($button) {
                    check_ajax_referer('rwps-ajax-button-nonce', 'nonce');
                    \call_user_func($button->getCallable(), $button);
                });
            }
        }

        foreach ($this->getPage()->getSections() as $section) {

            foreach ($section->getFields() as $field) {
                if ($upload_script_added === false && is_a($field, Upload::class)) {
                    add_action('admin_footer', array($this, 'media_fields'));
                    add_action('admin_enqueue_scripts', 'wp_enqueue_media');
                    $upload_script_added = true;
                }

                if ($ajax_button_script_added === false && is_a($field, AjaxButton::class)) {
                    add_action('admin_footer', array(&$this, 'ajax_button_script'));
                    $ajax_button_script_added = true;
                }

                if (is_a($field, AjaxButton::class)) {
                    /* @var AjaxButton $field */
                    add_action('wp_ajax_rwps_ajax_button_' . $field->getId(), function () use ($field) {
                        check_ajax_referer('rwps-ajax-button-nonce', 'nonce');
                        \call_user_func($field->getCallable(), $field);
                    });
                }
            }
        }

        $this->custom_hooks();
    }

    /**
     * @return static
     */
    public static function &init() {
        static $instance = null;
        /** @noinspection ClassConstantCanBeUsedInspection */
        $class = \get_called_class();
        if ($instance === null) {
            $instance = new $class();
        }
        return $instance;
    }

    abstract public function getPage(): Page;

    public function custom_hooks(): void {
    }

    final public function create_settings(): void {
        $page = $this->getPage();
        $callback = $page->getCallback() ?? array($this, 'settings_content');

        if ($this->getPage()->getParent() === null) {
            $this->hook_suffix = add_menu_page($page->getPageTitle(), $page->getMenuTitle(), $page->getCapability(), $page->getId(), $callback, $page->getIcon(), $page->getPosition());
        } else {
            $this->hook_suffix = add_submenu_page($this->getPage()
                                                       ->getParent(), $page->getPageTitle(), $page->getMenuTitle(), $page->getCapability(), $page->getId(), $callback);
        }


        if ($this->getPage()->getAdminFooterHook() !== null) {
            add_action('admin_footer-' . $this->hook_suffix, $this->getPage()->getAdminFooterHook());
        }

        if ($this->getPage()->getAssets()->count() > 0) {
            add_action('admin_enqueue_scripts', array(&$this, 'admin_enqueue_scripts'));
        }

    }

    final public function setup_sections(): void {
        foreach ($this->getPage()->getSections() as $section) {
            add_settings_section($section->getId(), $section->getTitle(), $section->getCallback(), $this->getPage()
                                                                                                        ->getId());
        }
    }

    final public function setup_fields(): void {
        foreach ($this->getPage()->getSections() as $section) {
            foreach ($section->getFields() as $field) {
                if (is_a($field, AjaxButton::class)) {
                    /* @var AjaxButton $field */

                    if ($field->getPosition() !== AjaxButton::POSITION_FORM) {
                        continue;
                    }

                }

                /* @var Field $field */
                add_settings_field($field->getId(), $field->getLabel(), array($this, 'field'), $this->getPage()
                                                                                                    ->getId(), $section->getId(), ['field' => $field]);
                $arguments = $field->getArguments();

                if (is_a($field, Upload::class)) {

                    $sanitize_callback = function ($value) use ($field, $arguments) {
                        if (!\is_array($value)) {
                            $value = '';
                        } else if (isset($value['attachment_id']) && empty($value['attachment_id'])) {
                            $value = '';
                        }

                        if ($field->getSanitizeCallback() !== null) {
                            $user_sanitize_callback = $field->getSanitizeCallback();
                            $value = $user_sanitize_callback($value);
                        }

                        return $value;
                    };

                    $arguments['sanitize_callback'] = $sanitize_callback;

                } else if ($field->getSanitizeCallback() !== null) {
                    $arguments['sanitize_callback'] = $field->getSanitizeCallback();
                }

                register_setting($this->getPage()->getId(), $field->getId(), $arguments);
            }
        }
    }

    final public function settings_content(): void { ?>
        <?php do_action('rwps-before-page-wrap', $this->getPage()); ?>
        <?php do_action('rwps-before-page-wrap-' . $this->getPage()->getId()); ?>
        <div class="wrap">
            <h1><?php echo $this->getPage()->getPageTitle(); ?></h1>
            <?php settings_errors(); ?>
            <!--suppress HtmlUnknownTarget -->
            <form method="POST" action="options.php">
                <?php do_action('rwps-before-form-fields', $this->getPage()); ?>
                <?php do_action('rwps-before-form-fields' . $this->getPage()->getId()); ?>
                <?php
                settings_fields($this->getPage()->getId());
                do_settings_sections($this->getPage()->getId());

                ?>
                <p class="submit">
                    <?php foreach ($this->getPage()->getButtons() as $button) {
                        if (is_a($button, AjaxButton::class) && $button->getPosition() === AjaxButton::POSITION_BEFORE_SUBMIT) {
                            echo $button->output('');
                        }
                    } ?>

                    <input type="submit"
                           class="button-primary"
                           value="<?php _e('Save Changes') ?>"
                    />
                    <?php foreach ($this->getPage()->getButtons() as $button) {
                        if (is_a($button, AjaxButton::class) && $button->getPosition() === AjaxButton::POSITION_AFTER_SUBMIT) {
                            echo $button->output('');
                        }
                    } ?>
                </p>
                <?php do_action('rwps-after-form-fields', $this->getPage()); ?>
                <?php do_action('rwps-after-form-fields' . $this->getPage()->getId()); ?>
            </form>
        </div>
        <?php
        do_action('rwps-after-page-wrap', $this->getPage());
        do_action('rwps-after-page-wrap-' . $this->getPage()->getId());
    }

    final public function field(array $args): void {
        /* @var Field $field ; */
        $field = $args['field'];
        $current_field_value = get_option($field->getId());
        echo $field->output($current_field_value, $args);
    }


    final public function ajax_button_script(): void {
        ?>
        <script>
            jQuery(document).ready(function ($) {

                var RWPSAjaxButtons = (function () {

                    var ajax_nonce = '<?php echo wp_create_nonce('rwps-ajax-button-nonce'); ?>';

                    function init() {

                        jQuery('.rwps-ajax-button').bind('click', function () {

                            var button = $(this);

                            var button_text = button.html();
                            var label_wait = button.data('wait-text');
                            var label_success = button.data('label-success');
                            var label_error = button.data('label-success');
                            var callback_success = button.data('callback-success');
                            var callback_error = button.data('callback-error');
                            var callback_done = button.data('callback-done');

                            var field_data = {};
                            var form = button.closest('form');
                            var fields = form.find('input, select');
                            var excluded_fields = ['action', '_wpnonce', '_wp_http_referer', 'submit'];

                            fields.each(function () {
                                var name = $(this).attr('name');
                                var id = $(this).attr('id');
                                var value = $(this).val();
                                if (jQuery.inArray(name, excluded_fields) === -1) {

                                    if (id === undefined) {
                                        id = name;
                                    }

                                    field_data[id] = value;
                                }
                            });

                            button.html(label_wait);
                            button.attr("disabled", "disabled");

                            jQuery.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                dataType: 'json',
                                data: {
                                    nonce: ajax_nonce,
                                    action: 'rwps_ajax_button_' + button.attr('id'),
                                    fields: field_data
                                }

                            }).fail(function (jqXHR, textStatus, errorThrown) {
                                if (label_error === '') {
                                    if (typeof jqXHR.responseJSON === 'object' && typeof jqXHR.responseJSON.data === 'string') {
                                        button.html(jqXHR.responseJSON.data);
                                    } else {
                                        button.html(button_text);
                                    }
                                } else {
                                    button.html(label_error);
                                }

                                if (callback_error !== '' && callback_error !== undefined) {
                                    executeCallback(callback_error, window, jqXHR, textStatus, errorThrown);
                                }
                            }).done(function (response, textStatus, jqXHR) {
                                if (label_success === '') {

                                    if (typeof response.data === 'string') {
                                        button.html(response.data);
                                    } else {
                                        button.html(button_text);
                                    }

                                } else {
                                    button.html(label_success);
                                }

                                if (callback_success !== '' && callback_success !== undefined) {
                                    executeCallback(callback_success, window, response, textStatus, jqXHR)
                                }

                            }).always(function (data_jqXHR, textStatus, jqXHR_errorThrown) {
                                setTimeout(function () {
                                    button.removeAttr('disabled');
                                    button.html(button_text);
                                }, 3000);


                                if (callback_done !== '' && callback_done !== undefined) {
                                    executeCallback(callback_done, window, data_jqXHR, textStatus, jqXHR_errorThrown)
                                }
                            });
                        });

                    }

                    function executeCallback(callback, context) {

                        var args = Array.prototype.slice.call(arguments, 2);
                        var namespaces = callback.split(".");
                        var func = namespaces.pop();
                        for (var i = 0; i < namespaces.length; i++) {
                            context = context[namespaces[i]];
                        }
                        return context[func].apply(context, args);


                    }

                    return {
                        init: init
                    }

                })();

                RWPSAjaxButtons.init();
            });
        </script>
        <?php
    }

    final public function media_fields(): void {
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
                                    multiple: false,
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
    public function getHookSuffix(): string {
        return $this->hook_suffix;
    }

    final public function admin_enqueue_scripts($hook): void {

        if ($this->getHookSuffix() === $hook) {

            foreach ($this->getPage()->getAssets() as $asset) {

                if (is_a($asset, AssetScript::class)) {
                    /* @var AssetScript $asset */
                    wp_enqueue_script($asset->getHandle(), $asset->getSrc(), $asset->getSrc(), $asset->getVer(), $asset->isInFooter());
                }

                if (is_a($asset, AssetStyle::class)) {
                    /* @var AssetStyle $asset */
                    wp_enqueue_style($asset->getHandle(), $asset->getSrc(), $asset->getSrc(), $asset->getVer(), $asset->getMedia());
                }
            }
        }
    }


}