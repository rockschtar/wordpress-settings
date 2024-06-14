jQuery(document).ready(function ($) {
  const RWPSUploadFile = (function () {
    function init() {
      jQuery('.rwps-file-upload-delete').bind('click', function () {
        const field = $(this)
        const fieldId = field.data('field-id')
        jQuery('#' + fieldId).val('')
        jQuery('#' + fieldId + '-file-link').remove()
        field.remove()

        return false
      })
    }

    return {
      init
    }
  })()

  RWPSUploadFile.init()
})
