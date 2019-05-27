<?php

use Rockschtar\WordPress\Settings\Controller\WordPressSettings;
use Rockschtar\WordPress\Settings\Models\SettingsPage;

if (function_exists('add_action')) {
    global $rswp_create_settings_action_added;

    if (!$rswp_create_settings_action_added) {
        add_action('_admin_menu', static function () {
            do_action('rswp_create_settings');
        }, 1);

        $rswp_create_settings_action_added = true;
    }
}

if (!function_exists('rswp_register_settings_page')) {
    function rswp_register_settings_page(SettingsPage $page): void {
        WordPressSettings::registerSettingsPage($page);
    }
}
