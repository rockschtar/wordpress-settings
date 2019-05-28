<?php

namespace Rockschtar\WordPress\Settings\Fields;

use Rockschtar\WordPress\Settings\Models\AssetScript;
use Rockschtar\WordPress\Settings\Models\AssetStyle;

class Select2Box extends SelectBox {

    /**
     * Select2Box constructor.
     * @param string $id
     */
    public function __construct(string $id) {
        parent::__construct($id);

        $this->addCssClass('rswp-select2');

        $this->addAsset(new AssetStyle('rswps-select2-style', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css'));

        $select2_script = new AssetScript('rswps-select2-script', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js', 'false', ['jquery']);
        $select2_script->addInlineScript("jQuery(function() {
            jQuery('.rswp-select2').select2();
        });");

        $this->addAsset($select2_script);
    }
}