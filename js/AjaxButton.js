jQuery(document).ready(function ($) {
  const RWPSAjaxButtons = (function () {
    const ajaxNonce = rwps_ajax_button.nonce

    function init() {
      jQuery('.rwps-ajax-button').bind('click', function () {
        const button = $(this)

        const buttonText = button.html()
        const labelWait = button.data('wait-text')
        const labelSuccess = button.data('label-success')
        const labelError = button.data('label-success')
        const callbackSuccess = button.data('callback-success')
        const callbackError = button.data('callback-error')
        const callbackDone = button.data('callback-done')

        const fieldData = {}
        const form = button.closest('form')
        const fields = form.find('input, select')
        const fieldsExcluded = [
          'action',
          '_wpnonce',
          '_wp_http_referer',
          'submit'
        ]

        fields.each(function () {
          const name = $(this).attr('name')
          let id = $(this).attr('id')
          const value = $(this).val()
          if (jQuery.inArray(name, fieldsExcluded) === -1) {
            if (id === undefined) {
              id = name
            }

            fieldData[id] = value
          }
        })

        button.html(labelWait)
        button.attr('disabled', 'disabled')

        jQuery
          .ajax({
            type: 'POST',
            url: ajaxurl,
            dataType: 'json',
            data: {
              nonce: ajaxNonce,
              action: 'rwps_ajax_button_' + button.attr('id'),
              fields: fieldData
            }
          })
          .fail(function (jqXHR, textStatus, errorThrown) {
            if (labelError === '') {
              if (
                typeof jqXHR.responseJSON === 'object' &&
                typeof jqXHR.responseJSON.data === 'string'
              ) {
                button.html(jqXHR.responseJSON.data)
              } else {
                button.html(buttonText)
              }
            } else {
              button.html(labelError)
            }

            if (callbackError !== '' && callbackError !== undefined) {
              executeCallback(
                callbackError,
                window,
                jqXHR,
                textStatus,
                errorThrown
              )
            }
          })
          .done(function (response, textStatus, jqXHR) {
            if (labelSuccess === '') {
              if (typeof response.data === 'string') {
                button.html(response.data)
              } else {
                button.html(buttonText)
              }
            } else {
              button.html(labelSuccess)
            }

            if (callbackSuccess !== '' && callbackSuccess !== undefined) {
              console.log('cb1', callbackSuccess)
              executeCallback(
                callbackSuccess,
                window,
                response,
                textStatus,
                jqXHR
              )
            }
          })
          .always(function (data, textStatus, errorThrown) {
            setTimeout(function () {
              button.removeAttr('disabled')
              button.html(buttonText)
            }, 3000)

            if (callbackDone !== '' && callbackDone !== undefined) {
              executeCallback(
                callbackDone,
                window,
                data,
                textStatus,
                errorThrown
              )
            }
          })
      })
    }

    function executeCallback(callback, context) {
      const args = Array.prototype.slice.call(arguments, 2)
      const namespaces = callback.split('.')
      const func = namespaces.pop()

      for (let i = 0; i < namespaces.length; i++) {
        context = context[namespaces[i]]
      }

      return context[func].apply(context, args)
    }

    return {
      init
    }
  })()

  RWPSAjaxButtons.init()
})
