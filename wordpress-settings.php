<?php

/**
 * WordPress Settings
 * @package     Rockschtar\WordPress\Settings
 * @author      Stefan Helmer
 * @copyright   2019 Stefan Helmer
 * @license     MIT
 * @wordpress-plugin
 * Plugin Name:  WordPress Settings
 * Plugin URI:   https://eracer.de
 * Description:  WordPress Settings Library
 * Version:      1.0.0
 * Requires PHP: 8.2
 * Requires at least: 6.4
 * Author: Stefan Helmer
 * Author URI: https://eracer.de
 * License: MIT License
 * License URI: https://tldrlegal.com/license/mit-license
 **/

define('RWPS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('RWPS_PLUGIN_URL', plugin_dir_url(__FILE__));


if (file_exists(RWPS_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php')) {
    require_once 'vendor/autoload.php';
} else {
    spl_autoload_register(static function ($class) {
        $baseDir = __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR;
        $prefix = 'Rockschtar\\WordPress\\Settings\\';
        $len = strlen($prefix);

        if (strncmp($prefix, $class, $len) !== 0) {
            return;
        }

        $relativeClass = substr($class, $len);
        $file = $baseDir . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';

        if (file_exists($file)) {
            include $file;
        }
    });
}

require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';
