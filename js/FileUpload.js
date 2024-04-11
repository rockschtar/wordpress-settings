require('jquery');
jQuery(document).ready(function ($) {

    var RWPSFileUpload = (function () {

        function init() {

            jQuery('.rwps-file-upload-delete').bind('click', function () {
                var field = $(this);
                var field_id = field.data('field-id');
                jQuery('#' + field_id).val('');
                jQuery('#' + field_id + '-file-link').remove();
                field.remove();

                return false;
            });
        }


        return {
            init: init
        }

    })();

    RWPSFileUpload.init();
});
