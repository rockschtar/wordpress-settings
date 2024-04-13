require('jquery')

jQuery(document).ready(function ($) {
  const RWPSMediaUpload = (function () {
    function init() {
      wp.media.RWPSUpload = {
        frame: function (buttonSender) {
          if (this._frame) {
            return this._frame
          }

          const that = this

          this._frame = wp.media({
            id: 'rwps-media-frame',
            title: 'Upload Title',
            editing: true,
            multiple: false
          })
          this._frame.on('select', function () {
            console.log(buttonSender)
            console.log(buttonSender.data('fieldid'))

            const attachment = that._frame
              .state()
              .get('selection')
              .first()
              .toJSON()
            onSelectMedia(buttonSender, attachment)
          })
          return this._frame
        },
        init: function () {}
      }

      $('.rwps_button_add_media').bind('click', function (event) {
        // eslint-disable-next-line
        const frame = new wp.media.RWPSUpload.frame($(this))
        frame.open()
      })

      $('.rwps_button_remove_media').bind('click', function (event) {
        event.preventDefault()
        onRemoveMedia($(this))
      })
    }

    function getElementsFromFieldId(fieldId) {
      const elements = []
      elements.imageThumbnail = $('#' + fieldId + '_thumb')
      elements.inputAttachmentUrl = $('input#' + fieldId)
      elements.inputAttachmentId = $('input#' + fieldId + '_attachment_id')
      elements.inputAttachmentIconUrl = $(
        'input#' + fieldId + '_attachment_icon'
      )
      elements.buttomRemove = $('input#' + fieldId + '_button_remove')
      return elements
    }

    function onSelectMedia(buttonSender, attachment) {
      const fieldId = buttonSender.data('fieldid')
      const elements = getElementsFromFieldId(fieldId)
      elements.inputAttachmentId.val(attachment.id)
      elements.inputAttachmentUrl.val(attachment.url)
      elements.inputAttachmentIconUrl.val(attachment.icon)
      if (mimeTypeIsImage(attachment.mime) === true) {
        elements.imageThumbnail.attr('src', attachment.url)
      } else {
        elements.imageThumbnail.attr('src', attachment.icon)
      }

      elements.buttomRemove.show()
      elements.imageThumbnail.show()
    }

    function onRemoveMedia(buttonSender) {
      const fieldId = buttonSender.data('fieldid')
      const elements = getElementsFromFieldId(fieldId)
      elements.imageThumbnail.hide()
      elements.imageThumbnail.attr('src', '')
      elements.inputAttachmentId.val('')
      elements.inputAttachmentUrl.val('')
      elements.inputAttachmentIconUrl.val('')
      elements.buttomRemove.hide()
    }

    function mimeTypeIsImage(mimeType) {
      const imageMimeTypes = [
        'image/bmp',
        'image/gif',
        'image/jpeg',
        'image/png',
        'image/svg+xml',
        'image/x-icon'
      ]
      return $.inArray(mimeType, imageMimeTypes) > -1
    }

    return {
      init
    }
  })()

  RWPSMediaUpload.init()
})
