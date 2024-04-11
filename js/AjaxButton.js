require('jquery');
jQuery(document).ready(function ($) {

    const RWPSAjaxButtons = (function () {

        const ajax_nonce = rwps_ajax_button.nonce;

        function init () {

            jQuery('.rwps-ajax-button').bind('click', function () {

                const button = $(this);

                const button_text = button.html();
                const label_wait = button.data('wait-text');
                const label_success = button.data('label-success');
                const label_error = button.data('label-success');
                const callback_success = button.data('callback-success');
                const callback_error = button.data('callback-error');
                const callback_done = button.data('callback-done');

                const field_data = {};
                const form = button.closest('form');
                const fields = form.find('input, select');
                const excluded_fields = [
                    'action',
                    '_wpnonce',
                    '_wp_http_referer',
                    'submit'];

                fields.each(function () {
                    const name = $(this).attr('name');
                    let id = $(this).attr('id');
                    const value = $(this).val();
                    if (jQuery.inArray(name, excluded_fields) === -1) {

                        if (id === undefined) {
                            id = name;
                        }

                        field_data[id] = value;
                    }
                });

                button.html(label_wait);
                button.attr('disabled', 'disabled');

                jQuery.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    dataType: 'json',
                    data: {
                        nonce: ajax_nonce,
                        action: 'rwps_ajax_button_' + button.attr('id'),
                        fields: field_data,
                    },

                }).fail(function (jqXHR, textStatus, errorThrown) {
                    if (label_error === '') {
                        if (typeof jqXHR.responseJSON === 'object' &&
                          typeof jqXHR.responseJSON.data === 'string') {
                            button.html(jqXHR.responseJSON.data);
                        }
                        else {
                            button.html(button_text);
                        }
                    }
                    else {
                        button.html(label_error);
                    }

                    if (callback_error !== '' && callback_error !== undefined) {
                        executeCallback(callback_error, window, jqXHR,
                          textStatus, errorThrown);
                    }
                }).done(function (response, textStatus, jqXHR) {
                    if (label_success === '') {

                        if (typeof response.data === 'string') {
                            button.html(response.data);
                        }
                        else {
                            button.html(button_text);
                        }

                    }
                    else {
                        button.html(label_success);
                    }

                    if (callback_success !== '' && callback_success !==
                      undefined) {
                        console.log('cb1', callback_success);
                        executeCallback(callback_success, window, response,
                          textStatus, jqXHR);
                    }

                }).always(function (data_jqXHR, textStatus, jqXHR_errorThrown) {
                    setTimeout(function () {
                        button.removeAttr('disabled');
                        button.html(button_text);
                    }, 3000);

                    if (callback_done !== '' && callback_done !== undefined) {
                        executeCallback(callback_done, window, data_jqXHR,
                          textStatus, jqXHR_errorThrown);
                    }
                });
            });

        }

        function executeCallback (callback, context) {

            const args = Array.prototype.slice.call(arguments, 2);
            const namespaces = callback.split('.');
            const func = namespaces.pop();


            for (let i = 0; i < namespaces.length; i++) {
                context = context[namespaces[i]];
            }

            return context[func].apply(context, args);
        }

        return {
            init: init,
        };

    })();

    RWPSAjaxButtons.init();
});
