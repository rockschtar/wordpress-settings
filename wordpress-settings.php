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

define('RWPS_PLUGIN_DIR', plugin_dir_path(__FILE__));

if (file_exists(RWPS_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php')) {
    require_once 'vendor/autoload.php';
}

add_action('_admin_menu', static function () {
    do_action('rswp_create_settings');
}, 1);

require_once __DIR__ . 'bootstrap.php';
