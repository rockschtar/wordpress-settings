<?php

namespace Rockschtar\WordPress\Settings\Fields;


use Rockschtar\WordPress\Settings\Models\AssetScript;

class Select2Box extends SelectBox {


    /**
     * Select2Box constructor.
     */
    public function __construct() {
        $d = new AssetScript('rswps-select2-script', RWPS_PLUGIN_URL)
    }
}