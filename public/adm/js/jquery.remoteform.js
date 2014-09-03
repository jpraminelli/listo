(function($) {

    $.fn.remoteform = function(options) {

        var defaults = {

            /**
             * Se deve setar o foco no primeiro campo do form automaticamente.
             */
            focusFirstField: true,
            /**
             * A classe (CSS) padrão para as mensagens de erro.
             */
            errorClass: 'tip', // bootstrap
            errorClassCampo: 'error',
            /**
             * Evento disparado quando o form recebe um 'ok' do servidor após um post bem sucedido.
             */
            onOk: function() {

            },
            /**
             * A URL de redirecionamento a ser utilizada quando o form for submetido com sucesso.
             */
            onOkForwardTo: null,
            /**
             * Evento disparado para cada erro de preenchimento encontrado.
             */
            onFieldError: function(field, error) {
                return true;
            },
            /**
             * Evento disparado no caso de um erro genérico.
             */
            onGeneralError: function(error) {
                return true;
            }
        };

        this.each(function() {

            var $this = $(this);
            var params = $.extend({}, defaults, options);

            var processing = false;
            var firstErrorField = null;

            if (params.focusFirstField === true) {
                $this.find('input:visible:first').focus();
            }

            // $this.attr('target', 'post_frame');
            $this.submit(function() {
                // event.preventDefault();
                if (processing) {
                    return false;
                    // return;
                }

                processing = true;
                $this.find('.help-inline').remove();

                $.post($this.attr('action'), $this.serialize(), function(response) {
                //console.log(response);
                    try {
                        if (response.code === 'OK') {
                            params.onOk();
                            // ok, deverá redirecionar para onde deve
                            if (response.forwardTo) {
                                window.location = response.forwardTo;
                            } else if (params.onOkForwardTo) {
                                window.location = params.onOkForwardTo;
                            }
                            processing = false;
                            return;
                        } else {
                            params.onGeneralError();
                        }
                        // limpa os erros antigos
                        //$('.' + params.errorClass).remove();
                        $('.has-error').removeClass('has-error');
                        $('span.error').remove();
                        $('.flash_messages').remove();

                        // Remove as mensagens de erro atuais
                        $('div.error').each(function() {
                            $(this).removeClass('error');
                        });

                        if (response.flashError) {
                            flashErrorHTML = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>';
                            flashErrorHTML += response.flashError;
                            flashErrorHTML += '</div>';
                            $('#flash').html(flashErrorHTML);
                        }

                        // mostra os erros de preenchimento do form
                        firstErrorField = null;
                        _recursiveSetErrorMessages(response.errors, '');

                        if (firstErrorField) {
                            $(firstErrorField).focus();
                        }
                    }
                    catch (e) {
                        if ($('meta[name=environment]').attr('content') !== 'production') {
                            //console.log(response);
                        }
                    }

                    processing = false;
                }, 'json');

                return false;
                // return;

            }); // submit

            function _recursiveSetErrorMessages(data, partialKey) {
                for (var key in data) {
                    var item = data[key];
                    if (typeof item === 'object') {
                        if (partialKey === '') {
                            _recursiveSetErrorMessages(item, key);
                        } else {
                            _recursiveSetErrorMessages(item, partialKey + '[' + key + ']');
                        }
                    } else if (typeof item === 'string') {
                        var campo = $this.find('[name="' + partialKey + '"]');
                        if (params.onFieldError(campo, item)) {

                            // alert(campo);
                            // alert(item);

                            $(campo).addClass(params.errorClassCampo).after('<span class="error help-block">' + item + '</span>');

                            // <span class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>

                            $(campo).addClass(params.errorClassCampo).parent().addClass('has-error');
                        }
                        if (!firstErrorField) {
                            firstErrorField = campo;
                        }
                    }
                }
            } // _recursiveSetErrorMessages

        }); // each

    }; // fn.remoteform

})(jQuery);
