(function($) {

    $.fn.magicform = function(options) {

        var defaults = {
            
            /**
             * Se deve setar o foco no primeiro campo do form automaticamente.
             */
            focusFirstField : true,
            
            /**
             * A classe (CSS) padrão para as mensagens de erro.
             */
            errorClass : 'help-inline', // bootstrap
            errorClassCampo : 'magicform_error_campo',
            
            /**
             * Evento disparado quando o form recebe um 'ok' do servidor após um post bem sucedido.
             */
            onOk : function() {
                
            },
            
            /**
             * A URL de redirecionamento a ser utilizada quando o form for submetido com sucesso.
             */
            onOkForwardTo : null,
            
            /**
             * Evento disparado para cada erro de preenchimento encontrado.
             */
            onFieldError : function(field, error) {
                return true;
            },
            
            /**
             * Evento disparado no caso de um erro genérico.
             */
            onGeneralError : function(error) {
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

            $this.attr('target', 'post_frame');
            $this.submit(function() {
                if (processing) {
                    return;
                }

                processing = true;

                $('#post_frame').remove();
                post_frame = $('<iframe name="post_frame" id="post_frame" src="" />');
                $(post_frame).css('display', 'none');
                $(post_frame).css('width', 0);
                $(post_frame).css('height', 0);
                $('body').append(post_frame);
                $(post_frame).load(function() {
                    response = $(post_frame).contents().text();
                    try {
                        response = jQuery.parseJSON(response);
                        if (response.code == 'OK') {
                            params.onOk();
                            // ok, deverá redirecionar para onde deve
                            if (response.forwardTo) {
                                window.location = response.forwardTo;
                            } else if (params.onOkForwardTo) {
                                window.location = params.onOkForwardTo;
                            }
                            processing = false;
                            return;
                        }

                        // limpa os erros antigos
                        $('.' + params.errorClassCampo).removeClass(params.errorClassCampo);
                        $('.' + params.errorClass).remove();

                        if (response.code == 'GENERAL_ERROR') {
                            onGeneralError = params.onGeneralError(response.message);
                            if (onGeneralError === true) {
                                if($('body > .container').length) {				    
                                    var html = '<div class="flash_messages"><div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">×</a>' + response.message + '</div></div>';
                                    $('.flash_messages').remove();
                                    $('body > .container').prepend(html);
                                } else{
                                    alert(response.message);
                                }
                            }
                            processing = false;
                            return;
                        }

                        // Remove as mensagens de erro atuais
                        $('div.error').each(function() {
                            $(this).removeClass('error');
                        });
                        
                        // mostra os erros de preenchimento do form
                        firstErrorField = null;
                        _recursiveSetErrorMessages(response.errors, '')
                        
                        if (firstErrorField) {
                            $('#' + $this.attr('id') + ' #' + firstErrorField).focus();
                        }
                    }
                    catch(e) {
                        if ($('meta[name=environment]').attr('content') != 'production') {
                            alert(response);
                        }
                    }
                
                    processing = false;
                
                }); // load
                
            }); // submit
            
            function _recursiveSetErrorMessages(data, partialKey) {
                for (var key in data) {
                    var item = data[key];
                    if (typeof item == 'object') {
                        if (partialKey == '') {
                            _recursiveSetErrorMessages(item, key);
                        } else {
                            _recursiveSetErrorMessages(item, partialKey + '-' + key);
                        }
                    } else if (typeof item == 'string') {
                        if(params.onFieldError(partialKey, item) !== false){
                            $('#' + $this.attr('id') + ' #' + partialKey).addClass(params.errorClassCampo).after('<span class="'+params.errorClass+'">' + item + '</span>');
                            $('#' + $this.attr('id') + ' #' + partialKey).addClass(params.errorClassCampo).parent().parent().addClass('error');
                            if (!firstErrorField) {
                                firstErrorField = partialKey;
                            }
                        }
                    }
                }
            } // _recursiveSetErrorMessages
            
        }); // each
        
    }; // fn.magicform
   
}) (jQuery);
