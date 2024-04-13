require('jquery');

jQuery(document).ready(function ($) {

  var RWPSMediaUpload = (function () {
    function init() {

      wp.media.RWPSUpload = {
        frame: function (buttonSender) {

          if (this._frame) {
            return this._frame;
          }

          var that = this;

          this._frame = wp.media({
            id: 'rwps-media-frame',
            title: 'Upload Title',
            editing: true,
            multiple: false
          });
          this._frame.on("select", function () {

              console.log(buttonSender);
              console.log(buttonSender.data('fieldid'));

              var attachment = that._frame.state().get('selection').first().toJSON();
              onSelectMedia(buttonSender, attachment);
            }
          );
          return this._frame;
        },
        init: function () {

        }
      };

      $('.rwps_button_add_media').bind('click', function (event) {
        var frame = new wp.media.RWPSUpload.frame($(this));
        frame.open();
      });

      $('.rwps_button_remove_media').bind('click', function (event) {
        event.preventDefault();
        onRemoveMedia($(this));
      });
    }

    function getElementsFromFieldId(fieldId) {
      var elements = [];
      elements['imageThumbnail'] = $('#' + fieldId + '_thumb');
      elements['inputAttachmentUrl'] = $('input#' + fieldId);
      elements['inputAttachmentId'] = $('input#' + fieldId + '_attachment_id');
      elements['inputAttachmentIconUrl'] = $('input#' + fieldId + '_attachment_icon');
      elements['buttomRemove'] = $('input#' + fieldId + '_button_remove');
      return elements;
    }

    function onSelectMedia(buttonSender, attachment) {
      var fieldId = buttonSender.data('fieldid');
      var elements = getElementsFromFieldId(fieldId);
      elements['inputAttachmentId'].val(attachment.id);
      elements['inputAttachmentUrl'].val(attachment.url);
      elements['inputAttachmentIconUrl'].val(attachment.icon);
      if (mimeTypeIsImage(attachment.mime) === true) {
        elements['imageThumbnail'].attr('src', attachment.url);
      } else {
        elements['imageThumbnail'].attr('src', attachment.icon);
      }

      elements['buttomRemove'].show();
      elements['imageThumbnail'].show();
    }

    function onRemoveMedia(buttonSender) {
      var fieldId = buttonSender.data('fieldid');
      var elements = getElementsFromFieldId(fieldId);
      elements['imageThumbnail'].hide();
      elements['imageThumbnail'].attr('src', '');
      elements['inputAttachmentId'].val('');
      elements['inputAttachmentUrl'].val('');
      elements['inputAttachmentIconUrl'].val('');
      elements['buttomRemove'].hide();
    }

    function mimeTypeIsImage(mime_type) {
      var image_mime_types = ['image/bmp',
        'image/gif',
        'image/jpeg',
        'image/png',
        'image/svg+xml',
        'image/x-icon'];
      return $.inArray(mime_type, image_mime_types) > -1;
    }

    return {
      init: init
    }

  })();

  RWPSMediaUpload.init();
});
