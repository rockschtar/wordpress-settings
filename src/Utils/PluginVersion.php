<?php

namespace Rockschtar\WordPress\Settings\Utils;

class PluginVersion
{
    public static function get(): string
    {
        if (!function_exists('get_plugin_data')) {
            require_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }

        $pluginData = get_plugin_data(RWPS_PLUGIN_FILE);
        return $pluginData['Version'];
    }
}
