<?php
/*
Plugin Name:  WordPress Settings
Plugin URI:   https://eracer.de
Description:  WordPress Settings Library
Version:      1.0.0
Requires PHP: 7.1
Requires at least: 5.2
Author: Stefan Helmer
Author URI: https://eracer.de
License: MIT License
License URI: https://tldrlegal.com/license/mit-license
*/

define('RWPS_PLUGIN_DIR', plugin_dir_path(__FILE__));

if (file_exists(RWPS_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php')) {
    require_once 'vendor/autoload.php';
}

require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';
