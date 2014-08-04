<?php

class Curriculos_Form_Lista extends Lib_Form
{

    public function init()
    {
        $this->setOptions(array('id' => get_class($this), 'class' => 'form-horizontal'));

        // ------------------------------------------------------------------------------------------------------------
        // ID
        // ------------------------------------------------------------------------------------------------------------
        $id = $this->createElement('hidden', 'id');
        $id->removeDecorator('Label');
        $this->addElement($id);

        // ============================================================================================================
        // CAMPO 'UTILIT�RIO' PARA GERENCIAR A EXCLUS�O DOS CURR�CULOS
        // ============================================================================================================
        $curriculos_para_remover = $this->createElement('hidden', 'curriculos_para_remover');
        $curriculos_para_remover->removeDecorator('label');
        $this->addElement($curriculos_para_remover);

        // ------------------------------------------------------------------------------------------------------------
        // NOME
        // ------------------------------------------------------------------------------------------------------------
        $nome = $this->createElement('text', 'nome');
        $nome->setLabel('Nome')
                ->setDescription('Nome de refer�ncia. Ex: Sele��o para Gerente de Marketing de Abril/2012.')
                ->setAttrib('class', 'span5')
                ->setRequired(true)
                ->setAttrib('maxlength', 100)
                ->addValidator('NotEmpty', true)
                ->addValidator('StringLength', false, array('max' => 100))
                ->addFilters(array('StringTrim', 'StripTags'));
        $this->addElement($nome);

        // ------------------------------------------------------------------------------------------------------------
        // DATA DE ABERTURA
        // ------------------------------------------------------------------------------------------------------------
        $data_abertura = $this->createElement('text', 'data_abertura');
        $data_abertura->setLabel('Data de abertura')
                ->setDescription('Define o in�cio da vig�ncia da lista. Normalmente o dia atual.')
                ->setAttrib('class', 'span2')
                ->setRequired(true)
                ->setAttrib('maxlength', 10)
                ->setAttrib('alt', 'date')
                ->addValidator('NotEmpty', true)
                ->addValidator('Date', false, array('format' => 'd/MM/y'))
                ->addValidator('StringLength', false, array('max' => 100))
                ->setValue(date('d/m/Y'));
        $this->addElement($data_abertura);

        // ------------------------------------------------------------------------------------------------------------
        // DATA DE FECHAMENTO
        // ------------------------------------------------------------------------------------------------------------
        $data_fechamento = $this->createElement('text', 'data_fechamento');
        $data_fechamento->setLabel('Data de fechamento')
                ->setDescription('Define o t�rmino da vig�ncia da lista.')
                ->setAttrib('class', 'span2')
                ->setAttrib('alt', 'date')
                ->addValidator('Date', false, array('format' => 'd/MM/y'))
                ->addValidator('StringLength', false, array('max' => 10))
                ->addFilter('Null');
        $this->addElement($data_fechamento);

        // ------------------------------------------------------------------------------------------------------------
        // ABERTURA DE VAGA?
        // ------------------------------------------------------------------------------------------------------------
        $abertura_box = $this->createElement('checkbox', 'abertura_box');
        $abertura_box->setLabel('Abertura de vaga?')
                ->setDescription('Se a lista corresponde diretamente � abertura de uma vaga, o sistema pode fazer uma 
                pr�-sele��o autom�tica dos curr�culos com maior pontua��o.')
                ->setIgnore(true);
        if (isset($this->_data['cargo_id']) && (int) $this->_data['cargo_id'] > 0) {
            $abertura_box->setValue(true);
        }
        $this->addElement($abertura_box);

        // ------------------------------------------------------------------------------------------------------------
        // �REA
        // ------------------------------------------------------------------------------------------------------------
        $areaTable = new Curriculos_Model_DbTable_Areas();
        $area = $this->createElement('select', 'area_id');
        $area->setLabel('�rea');
        $area->setAttrib('class', 'combo_area span3');
        $area->setOptions(array('multiOptions' => $areaTable->listaCombo()));
        $this->addElement($area);

        // ------------------------------------------------------------------------------------------------------------
        // CARGO
        // ------------------------------------------------------------------------------------------------------------
        if (isset($this->_data['area_id']) && (int) $this->_data['area_id'] > 0) {
            $cargosTable = new Curriculos_Model_DbTable_Cargos();
            $cargos = $cargosTable->listaCombo($this->_data['area_id']);
        } else {
            $cargos = array('' => 'Selecione...');
        }
        $cargo = $this->createElement('select', 'cargo_id');
        $cargo->setLabel('Cargo');
        $cargo->setAttrib('class', 'span3');
        $cargo->setOptions(array('multiOptions' => $cargos));
        $this->addElement($cargo);


        // Container onde est�o os combos para sele��o de �rea e cargo
        $this->addDisplayGroup(array('area_id', 'cargo_id'), 'abertura_group');

        // ------------------------------------------------------------------------------------------------------------
        // LISTA
        // ------------------------------------------------------------------------------------------------------------
        $curriculos = array();
        if (isset($this->_data['id']) && (int) $this->_data['id'] > 0) {
            $listasCurriculosTable = new Curriculos_Model_DbTable_ListasCurriculos();
            $curriculos = $listasCurriculosTable->listaPorLista($this->_data['id']);
        }
        $lista = new Curriculos_Form_ListaCurriculosElement($curriculos);
        $this->addElement($lista);

        // ------------------------------------------------------------------------------------------------------------
        // BOT�ES
        // ------------------------------------------------------------------------------------------------------------
        $this->addButtons();

        // ============================================================================================================
        // Decorators (bootstrap do twitter)
        // ============================================================================================================
        EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP, 'Salvar', 'Cancelar');
    }

}