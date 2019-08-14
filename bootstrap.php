<?php

use Rockschtar\WordPress\Settings\Controller\WordPressSettings;
use Rockschtar\WordPress\Settings\Models\SettingsPage;

if (function_exists('add_action')) {
    global $rwps_actions_added;

    if (!$rwps_actions_added) {

        add_action('wp_loaded', static function () {
            do_action('rswp_create_settings');
        }, 1);

        add_action('admin_action_rwps-load-script', static function () {
            /** @noinspection ProperNullCoalescingOperatorUsageInspection */
            $script = $_GET['script'] ?? '';
            $file = __DIR__ . DIRECTORY_SEPARATOR . 'scripts' . DIRECTORY_SEPARATOR . $script;
            echo file_get_contents($file);
            exit;

        });

        $rwps_actions_added = true;
    }
}

if (!function_exists('rswp_register_settings_page')) {
    function rswp_register_settings_page(SettingsPage $page) {
        WordPressSettings::registerSettingsPage($page);
    }
}
