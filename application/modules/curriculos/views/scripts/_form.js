function combo_escolaridade(){
    var escolaridade_id = new Number($('#escolaridade_id').val());

    if(escolaridade_id > 4) {
        $('#btn_adicionar_escolaridade').show();
        if($('.subform_escolaridades').length == 0) {
            $('#btn_adicionar_escolaridade').trigger('click');
        }
    } else {
        $('#btn_adicionar_escolaridade').hide();
        $('.subform_escolaridades .close.btn').trigger('click');
    }
}

$(function() {

    //<?php if (!IS_MOBILE) { ?>
    //
    $("#cpf").setMask({
        mask: "999.999.999-99",
        autoTab: false
    });
    $("#data_nascimento").setMask({
        mask: "99/99/9999",
        autoTab: false
    });
    $("#pretensao_salarial").setMask({
        mask: '99,999.999',
        type: 'reverse',
        autoTab: false
    });
    $(".telefone").setMask({
        mask: '(99) 9999-99999',
        autoTab: false
    });

    $('._contato_telefone').setMask({
        mask: '(99) 9999-99999',
        autoTab: false
    });
    //
    //<?php } ?>

    $('#escolaridade_id').change(combo_escolaridade);
    combo_escolaridade();

    $('#btn_adicionar_telefone').click(function() {
        var telefone_id = getTimestamp();
        var template = window.Curriculos_Form_CurriculoTelefone;
        template = template.replace(new RegExp('__TELEFONE_ID__', 'g'), telefone_id);
        $('#btn_adicionar_telefone').parent().parent().before(template);

        $(".telefone").setMask({
            mask: '(99) 9999-99999',
            autoTab: false
        });

        $('#telefones-' + telefone_id + '-numero').focus();
        return false;
    });

    $('#btn_adicionar_cargo').click(function() {
        var cargo_id = getTimestamp();
        var template = window.Curriculos_Form_CurriculoCargo;
        template = template.replace(new RegExp('__CARGO_ID__', 'g'), cargo_id);
        $('#btn_adicionar_cargo').parent().parent().before(template);
        $('#cargos-' + cargo_id + '-area_id').focus();
        return false;
    });

    $('#btn_adicionar_escolaridade').click(function() {
        var escolaridade_id = getTimestamp();
        var template = window.Curriculos_Form_CurriculoEscolaridade;
        template = template.replace(new RegExp('__ESCOLARIDADE_ID__', 'g'), escolaridade_id);
        $('#btn_adicionar_escolaridade').parent().parent().before(template);

        return false;
    });

    $('#btn_adicionar_curso').click(function() {
        var curso_id = getTimestamp();
        var template = window.Curriculos_Form_CurriculoCurso;
        template = template.replace(new RegExp('__CURSO_ID__', 'g'), curso_id);
        $('#btn_adicionar_curso').parent().parent().before(template);

        return false;
    });

    $('#btn_adicionar_experiencia').click(function() {
        var experiencia_id = getTimestamp();
        var template = window.Curriculos_Form_CurriculoExperiencia;
        template = template.replace(new RegExp('__EXPERIENCIA_ID__', 'g'), experiencia_id);
        $('#btn_adicionar_experiencia').parent().parent().before(template);

        $('#experiencias-' + experiencia_id + '-contato_telefone').setMask({
            mask: '(99) 9999-99999',
            autoTab: false
        });

        $('#experiencias-' + experiencia_id + '-empresa').focus();

        return false;
    });

    $('#btn_adicionar_anexo').click(function() {
        var anexo_id = getTimestamp();
        var template = window.Curriculos_Form_CurriculoAnexo;
        template = template.replace(new RegExp('__ANEXO_ID__', 'g'), anexo_id);
        $('#btn_adicionar_anexo').parent().parent().before(template);
        $('#anexos-' + anexo_id + '-descricao').focus();
        return false;
    });

    //<?php if (IN_BACKEND) { ?>
    //
    $('#btn_adicionar_nota').click(function() {
        var nota_id = getTimestamp();
        var template = window.Curriculos_Form_CurriculoNota;
        template = template.replace(new RegExp('__NOTA_ID__', 'g'), nota_id);
        $('#btn_adicionar_nota').parent().parent().before(template);
        $('#notas-' + nota_id + '-texto').focus();
        return false;
    });
    //
    //<?php } ?>

    $('.close').live('click', function() {
        var partes = $(this).attr('id').split('-');
        var entidade = partes[0];
        var id = partes[1];
        if (id.substr(0, 4) != 'new_') {
            var para_remover = '#' + entidade + '_para_remover';
            $(para_remover).val($(para_remover).val() + ' ' + id);
        }
        $(this).parent().remove();
        return false;
    });

    $('#btn_remover_foto').click(function() {
        var control_group = $(this).parent().parent();
        control_group.prev().remove();
        control_group.remove();
        $('#flag_remover_foto').val('1');
    });

    $('.combo_estado').change(function() {
        estado_id = $('#estado_id').val();
        url = '<?= WWWROOT ?>geo/consulta/lista-combo-cidades/uf/' + estado_id;
        $('#cidade_id').empty();
        $('#cidade_id').append('<option value="">Carregando...</option>');
        $.getJSON(url, function(data) {
            $('#cidade_id').empty();
            $.each(data, function(key, val) {
                $('#cidade_id').append('<option value="' + val.id + '">' + val.nome + '</option>');
            });
        });
    });

    $('.combo_area').live('change', function() {
        var area_id = $(this).val();
        var attr_id = $(this).attr('id');
        var id = attr_id.substr(7, attr_id.length - 15);
        var comboCargo = $('#cargos-' + id + '-cargo_id');
        var url = '<?= WWWROOT ?>curriculos/admin-cargos/lista-combo-cargos/area/' + area_id;

        comboCargo.empty();
        comboCargo.append('<option value="">Carregando...</option>');

        $.getJSON(url, function(data) {
            comboCargo.empty();
            $.each(data, function(key, val) {
                var _id = parseInt(val.id);
                var _flag = true;

                $('._cargo_id').each(function(k, v) {
                    v = $(v);
                    if(parseInt(v.val()) == _id){
                        _flag = false;
                    }
                });

                if(_flag){
                    comboCargo.append('<option value="' + val.id + '">' + val.nome + '</option>');
                }
            });
        });
    });
});

function getTimestamp() {
    var date = new Date;
    return 'new_' + date.getTime() + date.getMilliseconds();
}
