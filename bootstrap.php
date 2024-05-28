<?php

use Rockschtar\WordPress\Settings\Controller\SettingsController;
use Rockschtar\WordPress\Settings\Models\SettingsPage;

if (function_exists('add_action')) {
    if(!defined('RWPS_PLUGIN_DIR')) {
        define('RWPS_PLUGIN_DIR', plugin_dir_path(__FILE__));
    }

    if(!defined('RWPS_PLUGIN_URL')) {
        define('RWPS_PLUGIN_URL', plugin_dir_url(__FILE__));
    }
}

if (function_exists('add_action')) {
    global $rwps_actions_added;

    if (!$rwps_actions_added) {

        add_action('admin_menu', static function () {
            do_action('rswp_create_settings');
        }, 1);

        add_action('admin_action_rwps-load-script', static function () {
            header('Content-Type: application/javascript');
            $script = $_GET['script'] ?? '';
            $file = __DIR__ . '/dist/wp/' . $script;
            readfile($file);
            exit;

        });

        $rwps_actions_added = true;
    }
}

if (!function_exists('rswp_register_settings_page')) {
    function rswp_register_settings_page(SettingsPage $page) : void {
        SettingsController::registerSettingsPage($page);
    }
}
