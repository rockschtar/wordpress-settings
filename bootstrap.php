<?php

use Rockschtar\WordPress\Settings\Controller\SettingsController;
use Rockschtar\WordPress\Settings\Models\SettingsPage;

if (function_exists('plugin_dir_url')) {
    if(!defined('RWPS_PLUGIN_DIR')) {
        define('RWPS_PLUGIN_DIR', plugin_dir_path(__FILE__));
    }

    if(!defined('RWPS_PLUGIN_URL')) {
        define('RWPS_PLUGIN_URL', plugin_dir_url(__FILE__));
    }
}

if (function_exists('add_action')) {
    static $actionsAdded = false;

    if (!$actionsAdded) {

        add_action('wp_loaded', static function () {
            do_action('rswp_create_settings');
        }, 1);

        add_action('admin_action_rwps-load-script', static function () {
            $allowed = ['AjaxButton.js', 'UploadMedia.js', 'UploadFile.js'];
            $script = basename($_GET['script'] ?? '');

            if (!in_array($script, $allowed, true)) {
                wp_die('Not allowed', '', ['response' => 403]);
            }

            $file = __DIR__ . '/js/' . $script;

            if (!file_exists($file)) {
                wp_die('Not found', '', ['response' => 404]);
            }

            header('Content-Type: application/javascript');
            readfile($file);
            exit;
        });

        $actionsAdded = true;
    }
}

if (!function_exists('rswp_register_settings_page')) {
    function rswp_register_settings_page(SettingsPage $page) : void {
        SettingsController::registerSettingsPage($page);
    }
}
