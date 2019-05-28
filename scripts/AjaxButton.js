jQuery(document).ready(function ($) {

    var RWPSAjaxButtons = (function () {

        var ajax_nonce = rwps_ajax_button.nonce;

        function init() {

            jQuery('.rwps-ajax-button').bind('click', function () {

                var button = $(this);

                var button_text = button.html();
                var label_wait = button.data('wait-text');
                var label_success = button.data('label-success');
                var label_error = button.data('label-success');
                var callback_success = button.data('callback-success');
                var callback_error = button.data('callback-error');
                var callback_done = button.data('callback-done');

                var field_data = {};
                var form = button.closest('form');
                var fields = form.find('input, select');
                var excluded_fields = ['action', '_wpnonce', '_wp_http_referer', 'submit'];

                fields.each(function () {
                    var name = $(this).attr('name');
                    var id = $(this).attr('id');
                    var value = $(this).val();
                    if (jQuery.inArray(name, excluded_fields) === -1) {

                        if (id === undefined) {
                            id = name;
                        }

                        field_data[id] = value;
                    }
                });

                button.html(label_wait);
                button.attr("disabled", "disabled");

                jQuery.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    dataType: 'json',
                    data: {
                        nonce: ajax_nonce,
                        action: 'rwps_ajax_button_' + button.attr('id'),
                        fields: field_data
                    }

                }).fail(function (jqXHR, textStatus, errorThrown) {
                    if (label_error === '') {
                        if (typeof jqXHR.responseJSON === 'object' && typeof jqXHR.responseJSON.data === 'string') {
                            button.html(jqXHR.responseJSON.data);
                        } else {
                            button.html(button_text);
                        }
                    } else {
                        button.html(label_error);
                    }

                    if (callback_error !== '' && callback_error !== undefined) {
                        executeCallback(callback_error, window, jqXHR, textStatus, errorThrown);
                    }
                }).done(function (response, textStatus, jqXHR) {
                    if (label_success === '') {

                        if (typeof response.data === 'string') {
                            button.html(response.data);
                        } else {
                            button.html(button_text);
                        }

                    } else {
                        button.html(label_success);
                    }

                    if (callback_success !== '' && callback_success !== undefined) {
                        executeCallback(callback_success, window, response, textStatus, jqXHR)
                    }

                }).always(function (data_jqXHR, textStatus, jqXHR_errorThrown) {
                    setTimeout(function () {
                        button.removeAttr('disabled');
                        button.html(button_text);
                    }, 3000);


                    if (callback_done !== '' && callback_done !== undefined) {
                        executeCallback(callback_done, window, data_jqXHR, textStatus, jqXHR_errorThrown)
                    }
                });
            });

        }

        function executeCallback(callback, context) {

            var args = Array.prototype.slice.call(arguments, 2);
            var namespaces = callback.split(".");
            var func = namespaces.pop();
            for (var i = 0; i < namespaces.length; i++) {
                context = context[namespaces[i]];
            }
            return context[func].apply(context, args);


        }

        return {
            init: init
        }

    })();

    RWPSAjaxButtons.init();
});