<?php

namespace Rockschtar\WordPress\Settings\Fields;

use Rockschtar\WordPress\Settings\Enqueue\EnqueueScript;
use Rockschtar\WordPress\Settings\Enqueue\EnqueueStyle;

/**
 * This method is deprecated and will be removed in the next major release.
 *
 * @deprecated
 */
class Select2Box extends SelectBox
{
    public function __construct(string $id)
    {
        parent::__construct($id);

        $this->addCssClass('rswp-select2');

        $this->addEnqueue(new EnqueueStyle('rswps-select2-style', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css'));

        $select2_script = new EnqueueScript('rswps-select2-script', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js', 'false', ['jquery']);
        $select2_script->addInlineScript("jQuery(function() {
            jQuery('.rswp-select2').select2();
        });");

        $this->addEnqueue($select2_script);
    }
}
