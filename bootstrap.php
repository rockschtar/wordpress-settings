<?php

use Rockschtar\WordPress\Settings\Controller\WordPressSettings;
use Rockschtar\WordPress\Settings\Models\SettingsPage;

function rswp_register_settings_page(SettingsPage $page): void {
    WordPressSettings::registerSettingsPage($page);
}