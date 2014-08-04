<?php

class Curriculos_Form_Curriculo extends Lib_Form {

    private $_novo = false;

    public function init() {
        //TODO: no final do desenvolvimento, após a conclusão do módulo base de currículos, deverá ser adicionado o
        // campo "estado civil" (que é necessário no sistema da AGF).

        $action = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        $this->setOptions(array('id' => get_class($this), 'action' => $action, 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data'));

        $this->_novo = (bool) !(is_array($this->_data) && isset($this->_data['id']) && (int) $this->_data['id'] > 0);

        // ============================================================================================================
        // TEMPLATES DOS SUBFORMS
        // ============================================================================================================
        $telefoneTemplate = new Curriculos_Form_CurriculoTelefone(array('id' => '__TELEFONE_ID__'));
        $cargoTemplate = new Curriculos_Form_CurriculoCargo(array('id' => '__CARGO_ID__'));
        $experienciaTemplate = new Curriculos_Form_CurriculoExperiencia(array('id' => '__EXPERIENCIA_ID__'));
        $anexoTemplate = new Curriculos_Form_CurriculoAnexo(array('id' => '__ANEXO_ID__'));
        $notaTemplate = new Curriculos_Form_CurriculoNota(array('id' => '__NOTA_ID__'));
        $escolaridadeTemplate = new Curriculos_Form_CurriculoEscolaridade(array('id' => '__ESCOLARIDADE_ID__'));
        $cursoTemplate = new Curriculos_Form_CurriculoCurso(array('id' => '__CURSO_ID__'));
        //
        $this->getView()->inlineScript()->appendScript("
            window.Curriculos_Form_CurriculoTelefone = '" . str_replace(PHP_EOL, '', $telefoneTemplate->render()) . "';
            window.Curriculos_Form_CurriculoCargo = '" . str_replace(PHP_EOL, '', $cargoTemplate->render()) . "';
            window.Curriculos_Form_CurriculoExperiencia = '" . str_replace(PHP_EOL, '', $experienciaTemplate->render()) . "';
            window.Curriculos_Form_CurriculoAnexo = '" . str_replace(PHP_EOL, '', $anexoTemplate->render()) . "';
            window.Curriculos_Form_CurriculoNota = '" . str_replace(PHP_EOL, '', $notaTemplate->render()) . "';
            window.Curriculos_Form_CurriculoEscolaridade = '" . str_replace(PHP_EOL, '', $escolaridadeTemplate->render()) . "';
            window.Curriculos_Form_CurriculoCurso = '" . str_replace(PHP_EOL, '', $cursoTemplate->render()) . "';
        ");

        // ============================================================================================================
        // ID
        // ============================================================================================================
        // ------------------------------------------------------------------------------------------------------------
        // id (hidden)
        // ------------------------------------------------------------------------------------------------------------
        $id = $this->createElement('hidden', 'id');
        $id->removeDecorator('label');
        $this->addElement($id);

        // ============================================================================================================
        // CAMPOS 'UTILITÁRIOS' PARA GERENCIAR A EXCLUSÃO DE ITENS
        // ============================================================================================================
        $flag_remover_foto = $this->createElement('hidden', 'flag_remover_foto');
        $flag_remover_foto->removeDecorator('label');
        $this->addElement($flag_remover_foto);

        $telefones_para_remover = $this->createElement('hidden', 'telefones_para_remover');
        $telefones_para_remover->removeDecorator('label');
        $this->addElement($telefones_para_remover);

        $cargos_para_remover = $this->createElement('hidden', 'cargos_para_remover');
        $cargos_para_remover->removeDecorator('label');
        $this->addElement($cargos_para_remover);

        $escolaridades_para_remover = $this->createElement('hidden', 'escolaridades_para_remover');
        $escolaridades_para_remover->removeDecorator('label');
        $this->addElement($escolaridades_para_remover);

        $cursos_para_remover = $this->createElement('hidden', 'cursos_para_remover');
        $cursos_para_remover->removeDecorator('label');
        $this->addElement($cursos_para_remover);

        $experiencias_para_remover = $this->createElement('hidden', 'experiencias_para_remover');
        $experiencias_para_remover->removeDecorator('label');
        $this->addElement($experiencias_para_remover);

        $anexos_para_remover = $this->createElement('hidden', 'anexos_para_remover');
        $anexos_para_remover->removeDecorator('label');
        $this->addElement($anexos_para_remover);

        // Funções administrativas
        if (IN_BACKEND) {
            $notas_para_remover = $this->createElement('hidden', 'notas_para_remover');
            $notas_para_remover->removeDecorator('label');
            $this->addElement($notas_para_remover);
        }

        // ============================================================================================================
        // INFORMAÇÕES PARA LOGIN
        // ============================================================================================================
        // ------------------------------------------------------------------------------------------------------------
        // cpf
        // ------------------------------------------------------------------------------------------------------------
        $cpf = $this->createElement('text', 'cpf');
        $cpf->setLabel('CPF');
        $cpf->setAttrib('class', 'span2');
//        $cpf->setRequired(true);
        $cpf->setIgnore(true);
        $cpf->setAttrib('disabled', 'disabled');
//        $cpf->addFilters(array('StringTrim', 'StripTags', 'Digits'));
//        $cpf->addValidator('StringLength', false, array(11));
//        $cpf->addValidator(new Lib_Validate_Cpf(true), false);
        $this->addElement($cpf);

        // ------------------------------------------------------------------------------------------------------------
        // senha
        // ------------------------------------------------------------------------------------------------------------
        $senha = $this->createElement('password', 'senha');
        $senha->setLabel('Senha');
        $senha->setAttrib('class', 'span2');
        $senha->addValidator('StringLength', false, array('min' => 6, 'max' => 20));
        $senha->setAttrib('maxlength', '255');
        if ($this->_novo) {
            $senha->setRequired(true);
            $senha->addValidator('NotEmpty', false, array('min' => 6, 'max' => 20));
        }
        $this->addElement($senha);

        // ------------------------------------------------------------------------------------------------------------
        // senha (confirmação)
        // ------------------------------------------------------------------------------------------------------------
        $senha_confirmacao = $this->createElement('password', 'senha_confirmacao');
        $senha_confirmacao->setLabel('Confirmação da senha');
        $senha_confirmacao->setAttrib('class', 'span2');
        $senha_confirmacao->addValidator('StringLength', false, array('min' => 6, 'max' => 20));
        $senha_confirmacao->setAttrib('maxlength', '255');
        if ($this->_novo) {
            $senha_confirmacao->setRequired(true);
            $senha_confirmacao->addValidator('NotEmpty', false, array('min' => 6, 'max' => 20));
        }
        $this->addElement($senha_confirmacao);

        // ============================================================================================================
        // INFORMAÇÕES PESSOAIS
        // ============================================================================================================
        // ------------------------------------------------------------------------------------------------------------
        // nome
        // ------------------------------------------------------------------------------------------------------------
        $nome = $this->createElement('text', 'nome');
        $nome->setLabel('Nome completo');
        $nome->setAttrib('class', 'span3');
        $nome->setRequired(true);
        $nome->addFilters(array('StringTrim', 'StripTags'));
        $nome->setAttrib('maxlength', '50');
        $nome->addValidator('StringLength', false, array('max' => '100'));
        $this->addElement($nome);

        // ------------------------------------------------------------------------------------------------------------
        // e-mail
        // ------------------------------------------------------------------------------------------------------------
        $email = $this->createElement('text', 'email');
        $email->setLabel('E-mail');
        $email->setAttrib('class', 'span3');
        $email->setRequired(true);
        $email->addFilters(array('StringTrim', 'StripTags'));
        $email->setAttrib('maxlength', '100');
        $email->addValidator('StringLength', false, array('max' => '100'));
        $email->addValidator('EmailAddress', false);
        $this->addElement($email);

        // ------------------------------------------------------------------------------------------------------------
        // data de nascimento
        // ------------------------------------------------------------------------------------------------------------
        $data_nascimento = $this->createElement('text', 'data_nascimento');
        $data_nascimento->setLabel('Data de nascimento');
        $data_nascimento->setAttrib('class', 'span2');
        $data_nascimento->setRequired(true);
        $data_nascimento->addFilters(array('StringTrim', 'StripTags'));
        $data_nascimento->setAttrib('maxlength', '100');
        $data_nascimento->addValidator('StringLength', false, array(10));
        $data_nascimento->addValidator('Date', false, array('format' => Zend_Date::DAY . '/' . Zend_Date::MONTH . '/' . Zend_Date::YEAR));
        $this->addElement($data_nascimento);

        // ------------------------------------------------------------------------------------------------------------
        // sexo
        // ------------------------------------------------------------------------------------------------------------
        $sexo = $this->createElement('select', 'sexo');
        $sexo->setLabel('Sexo');
        $sexo->setAttrib('class', 'span2');
        $sexo->setRequired(true);
        $sexo->setOptions(array('multiOptions' => array('' => 'Selecione', 'M' => 'Masculino', 'F' => 'Feminino')));
        $this->addElement($sexo);

        // ------------------------------------------------------------------------------------------------------------
        // foto
        // ------------------------------------------------------------------------------------------------------------
        /* RETIRADO DE ACORDO COM TAREFA http://192.168.0.209/redmine/issues/58
         *
         * $foto = $this->createElement('file', 'foto');
          $foto->setLabel('Foto');
          $foto->setDescription('Imagem do tipo PNG ou JPG. Até 512Kb.');
          $foto->setAttrib('class', 'span3');
          $foto->addValidator('Extension', false, 'png,jpg,jpeg');
          $foto->addValidator('Size', false, 524288); // 512Kb=(524288) 1Mb=(1048576) 2Mb=(2097152)
          if ($_POST) {
          $foto->addFilter(new Zend_Filter_File_Rename(array('target' => Lib_UploadArea::getDir(), 'overwrite' => true)));
          }
          $this->addElement($foto); */

        // ------------------------------------------------------------------------------------------------------------
        // thumb
        // ------------------------------------------------------------------------------------------------------------
        $remover_foto = null;
        if (!$this->_novo && !$_POST) {
            $thumbUrl = $this->_record->thumbUrl();
            if ($thumbUrl) {
                $thumb = new Lib_Form_Element_Html('thumb');
                $thumb->setLabel('');
                $thumb->setValue('<img src="' . $thumbUrl . '" alt="Foto" />');
                $this->addElement($thumb);
                // botão para remover a foto atual
                $remover_foto = $this->createElement('button', 'btn_remover_foto');
                $remover_foto->setLabel('Remover foto atual');
                $remover_foto->setAttrib('class', 'btn btn-danger');
                $this->addElement($remover_foto);
            }
        }

        // ------------------------------------------------------------------------------------------------------------
        // endereço
        // ------------------------------------------------------------------------------------------------------------
        $endereco = $this->createElement('text', 'endereco');
        $endereco->setLabel('Endereço')
                ->setRequired(true)
                ->setAttrib('class', 'span6')
                ->addFilters(array('StringTrim', 'StripTags'))
                ->addValidator('NotEmpty', true)
                ->addValidator('StringLength', false, array('max' => 255));
        $this->addElement($endereco);

        // ------------------------------------------------------------------------------------------------------------
        // estado
        // ------------------------------------------------------------------------------------------------------------
        $estadosTable = new Geo_Model_DbTable_Estados();
        $estado = $this->createElement('select', 'estado_id');
        $estado->setLabel('Estado');
        $estado->setAttrib('class', 'combo_estado span2');
        $estado->setRequired(true);
        $estado->setOptions(array('multiOptions' => $estadosTable->listaCombo()));
        $this->addElement($estado);

        // ------------------------------------------------------------------------------------------------------------
        // cidade
        // ------------------------------------------------------------------------------------------------------------
        if (isset($this->_data['estado_id']) && strlen($this->_data['estado_id']) == 2) {
            $cidadesTable = new Geo_Model_DbTable_Cidades();
            $cidades = $cidadesTable->listaCombo($this->_data['estado_id']);
        } else {
            $cidades = array('' => 'Selecione...');
        }
        $cidade = $this->createElement('select', 'cidade_id');
        $cidade->setLabel('Cidade');
        $cidade->setAttrib('class', 'span3');
        $cidade->setRequired(true);
        $cidade->setOptions(array('multiOptions' => $cidades));
        $this->addElement($cidade);

        // ============================================================================================================
        // TELEFONES
        // ============================================================================================================
        $header_telefones = new Lib_Form_Element_Html('header_telefones');
        $header_telefones->setValue('<h2>Telefone</h2>');
        $header_telefones->setIgnore(true);
        $this->addElement($header_telefones);
        //
        if (isset($this->_data['telefones']) && is_array($this->_data['telefones'])) {
            foreach ($this->_data['telefones'] as $id => $telefone) {
                $telefone['id'] = $id;
                $form = new Curriculos_Form_CurriculoTelefone($telefone);
                $this->addSubForm($form, $form->getName());
            }
        }
        if ($this->_novo && !$_POST) {
            $form = new Curriculos_Form_CurriculoTelefone();
            $this->addSubForm($form, $form->getName());
        }

        // ------------------------------------------------------------------------------------------------------------
        // adicionar telefone
        // ------------------------------------------------------------------------------------------------------------
        $adicionar_telefone = $this->createElement('button', 'btn_adicionar_telefone');
        $adicionar_telefone->setLabel('Adicionar');
        $adicionar_telefone->setAttrib('class', 'btn btn-info');
        $this->addElement($adicionar_telefone);

        // ============================================================================================================
        // CARGO PRETENDIDO
        // ============================================================================================================
        $header_cargos = new Lib_Form_Element_Html('header_cargos');
        $header_cargos->setValue('<h2>Cargo pretendido</h2>');
        $header_cargos->setIgnore(true);
        $this->addElement($header_cargos);
        //
        if (isset($this->_data['cargos']) && is_array($this->_data['cargos'])) {
            foreach ($this->_data['cargos'] as $id => $cargo) {
                $cargo['id'] = $id;
                $form = new Curriculos_Form_CurriculoCargo($cargo);
                $this->addSubForm($form, $form->getName());
            }
        }
        if ($this->_novo && !$_POST) {
            $form = new Curriculos_Form_CurriculoCargo();
            $this->addSubForm($form, $form->getName());
        }
        // ------------------------------------------------------------------------------------------------------------
        // adicionar cargo
        // ------------------------------------------------------------------------------------------------------------
        $adicionar_cargo = $this->createElement('button', 'btn_adicionar_cargo');
        $adicionar_cargo->setLabel('Adicionar');
        $adicionar_cargo->setAttrib('class', 'btn btn-info');
        $this->addElement($adicionar_cargo);

        // ============================================================================================================
        // ESCOLARIDADE
        // ============================================================================================================
        $header_escolaridades = new Lib_Form_Element_Html('header_escolaridades');
        $header_escolaridades->setValue('<h2>Cursos / Formação</h2>');
        $header_escolaridades->setIgnore(true);
        $this->addElement($header_escolaridades);

        $escolaridade_id = $this->createElement('select', 'escolaridade_id');
        $escolaridade_id->setLabel('Escolaridade')
                ->setRequired(true)
                ->addValidator('NotEmpty', true)
                ->addMultiOptions(array('' => 'Selecione...') + Curriculos_Model_DbTable_Escolaridades::getFetchPairs(array('id', 'nome'), 'ativo IS TRUE', 'id ASC'));
        $this->addElement($escolaridade_id);

        if (isset($this->_data['escolaridades']) && is_array($this->_data['escolaridades'])) {
            foreach ($this->_data['escolaridades'] as $id => $escolaridade) {
                $escolaridade['id'] = $id;
                $form = new Curriculos_Form_CurriculoEscolaridade($escolaridade);
                $this->addSubForm($form, $form->getName());
            }
        }
        if (($this->_novo && !$_POST)) {
            $form = new Curriculos_Form_CurriculoEscolaridade();
            $this->addSubForm($form, $form->getName());
        }

        // ------------------------------------------------------------------------------------------------------------
        // adicionar escolaridade
        // ------------------------------------------------------------------------------------------------------------
        $adicionar_escolaridade = $this->createElement('button', 'btn_adicionar_escolaridade');
        $adicionar_escolaridade->setLabel('Adicionar');
        $adicionar_escolaridade->setAttrib('class', 'btn btn-info');
        $this->addElement($adicionar_escolaridade);

        // ============================================================================================================
        // CURSOS ADICIONAIS
        // ============================================================================================================
        $header_cursos = new Lib_Form_Element_Html('header_cursos');
        $header_cursos->setValue('<h2>Cursos Adicionais</h2>');
        $header_cursos->setIgnore(true);
        $this->addElement($header_cursos);
        //
        if (isset($this->_data['cursos']) && is_array($this->_data['cursos'])) {
            foreach ($this->_data['cursos'] as $id => $curso) {
                $curso['id'] = $id;
                $form = new Curriculos_Form_CurriculoCurso($curso);
                $this->addSubForm($form, $form->getName());
            }
        }
        if (($this->_novo && !$_POST)) {
            $form = new Curriculos_Form_CurriculoCurso();
            $this->addSubForm($form, $form->getName());
        }

        // ------------------------------------------------------------------------------------------------------------
        // adicionar escolaridade
        // ------------------------------------------------------------------------------------------------------------
        $adicionar_curso = $this->createElement('button', 'btn_adicionar_curso');
        $adicionar_curso->setLabel('Adicionar');
        $adicionar_curso->setAttrib('class', 'btn btn-info');
        $this->addElement($adicionar_curso);

        // ============================================================================================================
        // EXPERIÊNCIA PROFISSIONAL
        // ============================================================================================================
        $header_experiencias = new Lib_Form_Element_Html('header_experiencias');
        $header_experiencias->setValue('<h2>Experiência profissional</h2>');
        $header_experiencias->setIgnore(true);
        $this->addElement($header_experiencias);
        //
        if (isset($this->_data['experiencias']) && is_array($this->_data['experiencias'])) {
            foreach ($this->_data['experiencias'] as $id => $experiencia) {
                $experiencia['id'] = $id;
                $form = new Curriculos_Form_CurriculoExperiencia($experiencia);
                $this->addSubForm($form, $form->getName());
            }
        }
        if ($this->_novo && !$_POST) {
            $form = new Curriculos_Form_CurriculoExperiencia();
            $this->addSubForm($form, $form->getName());
        }

        // ------------------------------------------------------------------------------------------------------------
        // adicionar experiência
        // ------------------------------------------------------------------------------------------------------------
        $adicionar_experiencia = $this->createElement('button', 'btn_adicionar_experiencia');
        $adicionar_experiencia->setLabel('Adicionar');
        $adicionar_experiencia->setAttrib('class', 'btn btn-info');
        $this->addElement($adicionar_experiencia);

        // ============================================================================================================
        // ANEXOS
        // ============================================================================================================


        $header_anexos = new Lib_Form_Element_Html('header_anexos');
        $header_anexos->setValue('<h2>Anexo</h2>');
        $header_anexos->setIgnore(true);
        $this->addElement($header_anexos);
        //
        if (isset($this->_data['anexos']) && is_array($this->_data['anexos'])) {
            foreach ($this->_data['anexos'] as $id => $anexo) {
                $anexo['id'] = $id;
                $form = new Curriculos_Form_CurriculoAnexo($anexo);
                $this->addSubForm($form, $form->getName());
            }
        }

        // ------------------------------------------------------------------------------------------------------------
        // adicionar anexo
        // ------------------------------------------------------------------------------------------------------------
        $adicionar_anexo = $this->createElement('button', 'btn_adicionar_anexo');
        $adicionar_anexo->setLabel('Adicionar');
        $adicionar_anexo->setAttrib('class', 'btn btn-info');
        $this->addElement($adicionar_anexo);


        // ============================================================================================================
        // PRETENSÃO SALARIAL
        // ============================================================================================================
        $pretensao_salarial = $this->createElement('text', 'pretensao_salarial');
        $pretensao_salarial->setLabel('Pretensão salarial');
        $pretensao_salarial->setAttrib('class', 'span2');
        $pretensao_salarial->setRequired(true);
        $pretensao_salarial->addFilters(array('StringTrim', 'StripTags'));
        $pretensao_salarial->setAttrib('maxlength', '100');
        $pretensao_salarial->addValidator('StringLength', false, array('max' => '100'));
        $this->addElement($pretensao_salarial);

        // ============================================================================================================
        // Disponibilidade para viajar
        // ============================================================================================================
        $disponibilidade_viagens = $this->createElement('select', 'disponibilidade_viagens');
        $disponibilidade_viagens->setLabel('Disponibilidade para viajar?')
                ->setAttrib('class', 'span2')
                ->setRequired(true)
                ->addValidator('NotEmpty', true)
                ->addMultiOptions(array('' => 'Selecione...', '1' => 'Sim', '0' => 'Não'));
        $this->addElement($disponibilidade_viagens);

        // ============================================================================================================
        // Disponibilidade para trabalhar em todas as regiões do país?
        // ============================================================================================================
        $disponibilidade_regioes = $this->createElement('select', 'disponibilidade_todas_regioes');
        $disponibilidade_regioes->setLabel('Disponibilidade para trabalhar em todas as regiões do país?')
                ->setAttrib('class', 'span2')
                ->setRequired(true)
                ->addValidator('NotEmpty', true)
                ->addMultiOptions(array('' => 'Selecione...', '1' => 'Sim', '0' => 'Não'));
        $this->addElement($disponibilidade_regioes);

        // ============================================================================================================
        // OBSERVAÇÕES GERAIS
        // ============================================================================================================
        $observacoes_gerais = $this->createElement('textarea', 'observacoes_gerais');
        $observacoes_gerais->setLabel('Observações gerais');
        $observacoes_gerais->setAttrib('class', 'span3');
        $observacoes_gerais->setAttrib('cols', '120');
        $observacoes_gerais->setAttrib('rows', '5');
        $observacoes_gerais->addFilters(array('StringTrim', 'StripTags'));
        $observacoes_gerais->addValidator('StringLength', false, array('max' => '32000'));
        $this->addElement($observacoes_gerais);

        // ############################################################################################################
        // ############################################################################################################
        // ############################################################################################################
        //
        // FUNÇÕES ADMINISTRATIVAS - DISPONÍVEIS SOMENTE SE O USUÁRIO ESTIVER OPERANDO A PARTIR DO BACK-END
        //
        // ############################################################################################################
        // ############################################################################################################
        // ############################################################################################################

        if (IN_BACKEND) {

            // ========================================================================================================
            // PONTUAÇÃO
            // ========================================================================================================
            $pontuacao = $this->createElement('text', 'pontuacao');
            $pontuacao->setLabel('Pontuação');
            $pontuacao->setAttrib('class', 'span1');
            $pontuacao->addFilters(array('StringTrim', 'StripTags'));
            $pontuacao->setAttrib('maxlength', '4');
            $pontuacao->addValidator('StringLength', false, array('max' => '4'));
            $this->addElement($pontuacao);

            // ========================================================================================================
            // NOTAS
            // ========================================================================================================
            $header_notas = new Lib_Form_Element_Html('header_notas');
            $header_notas->setValue('<h2>Notas</h2>');
            $header_notas->setIgnore(true);
            $this->addElement($header_notas);
            //
            if (isset($this->_data['notas']) && is_array($this->_data['notas'])) {
                foreach ($this->_data['notas'] as $id => $nota) {
                    $nota['id'] = $id;
                    $form = new Curriculos_Form_CurriculoNota($nota);
                    $this->addSubForm($form, $form->getName());
                }
            }
            // --------------------------------------------------------------------------------------------------------
            // adicionar nota
            // --------------------------------------------------------------------------------------------------------
            $adicionar_nota = $this->createElement('button', 'btn_adicionar_nota');
            $adicionar_nota->setLabel('Adicionar');
            $adicionar_nota->setAttrib('class', 'btn btn-info');
            $this->addElement($adicionar_nota);

            // ========================================================================================================
            // ATIVO
            // ========================================================================================================
            $ativo = new Zend_Form_Element_Checkbox('ativo');
            $ativo->setLabel('Ativo');
            $ativo->setValue(1);
            $this->addElement($ativo);
        }

        // ------------------------------------------------------------------------------------------------------------
        // BOTÕES
        // ------------------------------------------------------------------------------------------------------------
        $this->addButtons();

        // ============================================================================================================
        // Decorators (bootstrap do twitter)
        // ============================================================================================================
        EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP, 'Salvar', 'Cancelar');

        // ------------------------------------------------------------------------------------------------------------
        // Ajustes que precisam ser realizados após processar os decorators
        // ------------------------------------------------------------------------------------------------------------
        if ($remover_foto) {
            $remover_foto->removeDecorator('Label');
        }
        $header_telefones->setDecorators(array('ViewHelper'));
        $adicionar_telefone->removeDecorator('Label');

        $header_cargos->setDecorators(array('ViewHelper'));
        $adicionar_cargo->removeDecorator('Label');

        $header_escolaridades->setDecorators(array('ViewHelper'));
        $adicionar_escolaridade->removeDecorator('Label');

        $header_cursos->setDecorators(array('ViewHelper'));
        $adicionar_curso->removeDecorator('Label');

        $header_experiencias->setDecorators(array('ViewHelper'));
        $adicionar_experiencia->removeDecorator('Label');

        // ANEXO RETIRADO DE ACORDO COM A TAREFA http://192.168.0.209/redmine/issues/58
        /* $header_anexos->setDecorators(array('ViewHelper'));
          $adicionar_anexo->removeDecorator('Label'); */

        if ($header_notas) {
            $header_notas->setDecorators(array('ViewHelper'));
        }
        if ($adicionar_nota) {
            $adicionar_nota->removeDecorator('Label');
        }
    }

    public function isValid($data) {
        if ($this->_novo) {
            $id = null;
        } else {
            $id = $this->_data['id'];
        }
        // Senha
        $valid = parent::isValid($data);
        $senhaElement = $this->getElement('senha');
        $senhaConfirmacaoElement = $this->getElement('senha_confirmacao');
        $senha = $senhaElement->getValue();
        $senhaConfirmacao = $senhaConfirmacaoElement->getValue();
        if (($senha) && ($senha != $senhaConfirmacao)) {
            $senhaConfirmacaoElement->addError('A senha não confere!');
            $valid = false;
        }
        // Data de nascimento
        $dataNascimentoElement = $this->getElement('data_nascimento');
        $dataNascimento = $dataNascimentoElement->getValue();
        if (!Lib_Data::isDate($dataNascimento)) {
            $dataNascimentoElement->addError('Esta data não é válida.');
            $valid = false;
        }
        // E-mail
        $emailElement = $this->getElement('email');
        $email = $emailElement->getValue();
        $curriculosTable = new Curriculos_Model_DbTable_Curriculos();
        if ($email && $curriculosTable->existeEmail($email, $id)) {
            $emailElement->addError('E-mail já utilizado.');
            $valid = false;
        }
        // CPF
        $cpfElement = $this->getElement('cpf');
        $cpf = $cpfElement->getValue();
        $curriculosTable = new Curriculos_Model_DbTable_Curriculos();
        if ($cpf && $curriculosTable->existeCpf($cpf, $id)) {
            $cpfElement->addError('CPF já utilizado.');
            $valid = false;
        }
        return $valid;
    }

}
