<?php
/*
Plugin Name:  WordPress Settings
Plugin URI:   https://validio.de
Description:  WordPress Settings Library
Version:      1.0.0
Author:       Stefan Helmer
Author URI:   https://validio.io/
License:      MIT License
*/

require_once 'vendor/autoload.php';


function rwps_create_settings(\Rockschtar\WordPress\Settings\Models\Page $page): void {
    \Rockschtar\WordPress\Settings\Controller\WordPressSettings::init($page);
}