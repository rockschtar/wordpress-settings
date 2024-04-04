<?php

namespace Rockschtar\WordPress\Settings\Controller;

use Closure;
use JetBrains\PhpStorm\NoReturn;
use Rockschtar\WordPress\Settings\Fields\AjaxButton;
use Rockschtar\WordPress\Settings\Fields\UploadFile;
use Rockschtar\WordPress\Settings\Fields\UploadMedia;
use Rockschtar\WordPress\Settings\Models\Asset;
use Rockschtar\WordPress\Settings\Models\AssetScript;
use Rockschtar\WordPress\Settings\Models\AssetStyle;
use Rockschtar\WordPress\Settings\Models\Button;
use Rockschtar\WordPress\Settings\Models\SettingsPage;

use function call_user_func;
use function is_array;

class SettingsController
{
    private SettingsPage $page;

    private string $hookSuffix;

    private function __construct(SettingsPage $page)
    {
        $this->page = $page;

        add_action('admin_menu', $this->addMenus(...));
        add_action('admin_init', $this->addSettingsSections(...));
        add_action('admin_init', $this->addSettingsFields(...));
        add_action('wp_ajax_rwps_delete_fileupload', $this->ajaxDeleteFileUpload(...));

        foreach ($this->page->getSections() as $section) {
            foreach ($section->getFields() as $field) {
                if ($field->getDefaultOption() !== null) {
                    add_filter('default_option_' . $field->getId(), static function ($default) use ($field) {
                        if ($default === false) {
                            $default = $field->getDefaultOption();
                        }

                        return $default;
                    }, 10, 1);
                }
            }
        }


        if (is_admin()) {
            $this->adminHooks();
        }
    }

    public static function registerSettingsPage(SettingsPage $page): SettingsController
    {
        return new SettingsController($page);
    }

    private function adminHooks(): void
    {
        $upload_script_added = false;

        foreach ($this->page->getButtons() as $button) {
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

        foreach ($this->page->getSections() as $section) {
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

                if (is_a($field, UploadFile::class)) {
                    /* @var $field UploadFile */
                    $file_upload_id = $field->getId() . '-file-upload';

                    add_filter(
                        'pre_update_option_' . $field->getId(),
                        function ($value, $old_value) use ($field, $file_upload_id) {
                            if ($_FILES[$file_upload_id]['error'] === 0) {
                                $filename = $_FILES[$file_upload_id]['name'];
                                $content = file_get_contents($_FILES[$file_upload_id]['tmp_name']);

                                $value = $this->allowedMimeTypesFilter(
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

                            if (
                                ($_FILES[$file_upload_id]['error'] === UPLOAD_ERR_NO_FILE) && empty(
                                    $_POST[$field->getId()]
                                ) && isset($old_value['file'])
                            ) {
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
                            /* @var UploadFile $field */
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

                if ($upload_script_added === false && is_a($field, UploadMedia::class)) {
                    add_action('admin_enqueue_scripts', 'wp_enqueue_media');
                    add_action('admin_enqueue_scripts', static function () {
                        wp_enqueue_script(
                            'rwsp-media-upload',
                            RWPS_PLUGIN_URL . '/scripts/MediaUpload.js',
                            ['jquery'],
                            null,
                            true
                        );
                    });

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

    #[NoReturn]
    private function ajaxDeleteFileUpload(): void
    {
        $option = $_POST['option'];
        $option_value = get_option($option);
        unlink($option_value['file']);

        wp_send_json_success();
    }

    public function getHookSuffix(): string
    {
        return $this->hookSuffix;
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

    final public function adminEnqueueScripts($hook): void
    {
        if ($this->getHookSuffix() === $hook) {
            foreach ($this->page->getSections() as $section) {
                foreach ($section->getFields() as $field) {
                    foreach ($field->getAssets() as $asset) {
                        $this->enqueueAsset($asset);
                    }
                }
            }

            foreach ($this->page->getFields() as $field) {
                foreach ($field->getAssets() as $asset) {
                    $this->enqueueAsset($asset);
                }
            }

            foreach ($this->page->getButtons() as $button) {
                foreach ($button->getAssets() as $asset) {
                    $this->enqueueAsset($asset);
                }
            }


            foreach ($this->page->getAssets() as $asset) {
                $this->enqueueAsset($asset);
            }
        }
    }

    private function allowedMimeTypesFilter(UploadFile $field, ?Closure $closure = null)
    {
        $mimeTypesFilter = static function ($mimeTypes) use ($field) {
            if ($field->isAppendMimeTypes()) {
                return array_merge($mimeTypes, $field->getAllowedMimeTypes());
            }

            return $field->getAllowedMimeTypes();
        };

        add_filter('upload_mimes', $mimeTypesFilter);

        $value = true;

        if ($closure) {
            $value = $closure();
        }

        remove_filter('upload_mimes', $mimeTypesFilter);

        return $value;
    }


    private function addMenus(): void
    {
        $page = $this->page;
        $callback = $page->getCallback() ?? $this->outputPage(...);

        if ($this->page->getParent() === null) {
            $this->hookSuffix = add_menu_page(
                $page->getPageTitle(),
                $page->getMenuTitle(),
                $page->getCapability(),
                $page->getId(),
                $callback,
                $page->getIcon(),
                $page->getPosition()
            );
        } else {
            $this->hookSuffix = add_submenu_page(
                $this->page
                    ->getParent(),
                $page->getPageTitle(),
                $page->getMenuTitle(),
                $page->getCapability(),
                $page->getId(),
                $callback,
                $page->getPosition()
            );
        }


        if ($this->page->getAdminFooterHook() !== null) {
            add_action('admin_footer-' . $this->hookSuffix, $this->page->getAdminFooterHook());
        }

        add_action('admin_enqueue_scripts', $this->adminEnqueueScripts(...));
    }

    private function addSettingsSections(): void
    {
        foreach ($this->page->getSections() as $section) {
            add_settings_section(
                $section->getId(),
                $section->getTitle(),
                $section->getCallback(),
                $this->page
                    ->getId()
            );
        }
    }

    private function addSettingsFields(): void
    {
        foreach ($this->page->getSections() as $section) {
            foreach ($section->getFields() as $field) {
                if (is_a($field, AjaxButton::class) && $field->getPosition() !== Button::POSITION_FORM) {
                    continue;
                }

                add_settings_field(
                    $field->getId(),
                    $field->getLabel(),
                    static function ($args) use ($field) {
                        echo $field->processOutput($args);
                    },
                    $this->page->getId(),
                    $section->getId()
                );
                $arguments = $field->getSanitizeArguments();

                if ($field->getType() !== null) {
                    $arguments['type'] = $field->getType();
                }


                $userSanitizeCallback = static function ($value) use ($field) {
                    if ($field->getSanitizeCallback() !== null) {
                        $user_sanitize_callback = $field->getSanitizeCallback();
                        $value = $user_sanitize_callback($value);
                    }

                    return $value;
                };

                if (is_a($field, UploadMedia::class)) {
                    $sanitizeCallback = $field->getSanitizeCallback() ?? static function ($value) use (
                        $userSanitizeCallback
                    ) {
                        if (!is_array($value) || (isset($value['attachment_id']) && empty($value['attachment_id']))) {
                            $value = '';
                        }

                        return $userSanitizeCallback($value);
                    };
                    $arguments['sanitize_callback'] = $sanitizeCallback;
                } elseif (is_a($field, UploadFile::class)) {
                    $sanitizeCallback = function ($value) use ($field, $userSanitizeCallback) {
                        $fileUploadId = $field->getId() . '-file-upload';

                        if ($_FILES[$fileUploadId]['error'] === 0) {
                            $mime_type_allowed = $this->allowedMimeTypesFilter(
                                $field,
                                function () use ($fileUploadId) {
                                    $mime_type = mime_content_type($_FILES[$fileUploadId]['tmp_name']);

                                    $allowed_mime_types = get_allowed_mime_types();
                                    $mime_type_allowed = false;

                                    foreach ($allowed_mime_types as $key => $current_mime_type) {
                                        if ($current_mime_type === $mime_type) {
                                            $mime_type_allowed = true;
                                            break;
                                        }
                                    }

                                    return $mime_type_allowed;
                                }
                            );


                            if ($mime_type_allowed === false) {
                                add_settings_error(
                                    $field->getId(),
                                    $field->getId(),
                                    __('Sorry, this file type is not permitted for security reasons.')
                                );
                            }
                        }

                        return $userSanitizeCallback($value);
                    };
                    $arguments['sanitize_callback'] = $sanitizeCallback;
                } elseif ($field->getSanitizeCallback() !== null) {
                    $arguments['sanitize_callback'] = $field->getSanitizeCallback();
                }


                register_setting($this->page->getId(), $field->getId(), $arguments);
            }
        }
    }

    private function outputPage(): void
    {
        $settingsErrors = '';

        ob_start();
        settings_fields($this->page->getId());
        $settingsFields = ob_get_clean();

        ob_start();
        do_settings_sections($this->page->getId());
        $doSettingsSection = ob_get_clean();

        ob_start();
        submit_button();
        $submitButton = ob_get_clean();

        if ($this->page->getParent() === null) {
            ob_start();
            settings_errors();
            $settingsErrors = ob_get_clean();
        }


        $ajaxButtonsBeforeSubmit = '';
        $ajaxButtonsAfterSubmit = '';

        foreach ($this->page->getButtons() as $button) {
            if (is_a($button, AjaxButton::class)) {
                if ($button->getPosition() === Button::POSITION_BEFORE_SUBMIT) {
                    $ajaxButtonsBeforeSubmit .= $button->processOutput();
                } else {
                    $ajaxButtonsAfterSubmit .= $button->processOutput();
                }
            }
        }

        $output = <<<HTML
            <div class="wrap">
                <h1>{$this->page->getPageTitle()}</h1>
                $settingsErrors
                <form method="POST" action="options.php" enctype="multipart/form-data">
                    $settingsFields
                    $doSettingsSection
                
                    <p class="submit">
                        $ajaxButtonsBeforeSubmit
                        $submitButton
                        $ajaxButtonsAfterSubmit
                    </p>
                </form>
            </div>
        HTML;

        echo $output;
    }
}
