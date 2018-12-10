<?php

if (function_exists('add_action')) {
    add_action('init', function () {
        do_action('rwps_create_settings');
    }, 1);
}

function rwps_create_settings(\Rockschtar\WordPress\Settings\Models\SettingsPage $page): void {
    \Rockschtar\WordPress\Settings\Controller\WordPressSettings::init($page);
}
