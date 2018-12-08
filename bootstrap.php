<?php

function rwps_create_settings(\Rockschtar\WordPress\Settings\Models\Page $page): void {
    \Rockschtar\WordPress\Settings\Controller\WordPressSettings::init($page);
}
