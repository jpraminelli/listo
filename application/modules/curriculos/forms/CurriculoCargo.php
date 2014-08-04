<?php

class Curriculos_Form_CurriculoCargo extends Lib_Form_SubForm
{

    public function init()
    {
        if ($this->_data && isset($this->_data['id'])) {
            $recid = $this->_data['id'];
        } else {
            $recid = 'new_' . time();
        }
        $this->setName("cargos_$recid");
        $this->setElementsBelongTo("cargos[$recid]");

        // ------------------------------------------------------------------------------------------------------------
        // id (hidden)
        // ------------------------------------------------------------------------------------------------------------
        $id = $this->createElement('hidden', 'id');
        $id->removeDecorator('label');
        $id->setValue($recid);
        $this->addElement($id);

        // ------------------------------------------------------------------------------------------------------------
        // área
        // ------------------------------------------------------------------------------------------------------------
        $areaTable = new Curriculos_Model_DbTable_Areas();
        $area = $this->createElement('select', 'area_id');
        $area->setLabel('Área');
        $area->setAttrib('class', 'combo_area span3');
        $area->setRequired(true);
        $area->setOptions(array('multiOptions' => $areaTable->listaCombo()));
        $this->addElement($area);

        // ------------------------------------------------------------------------------------------------------------
        // cargo
        // ------------------------------------------------------------------------------------------------------------
        if (isset($this->_data['area_id']) && (int) $this->_data['area_id'] > 0) {
            $cargosTable = new Curriculos_Model_DbTable_Cargos();
            $cargos = $cargosTable->listaCombo($this->_data['area_id']);
        } else {
            $cargos = array('' => 'Selecione...');
        }
        $cargo = $this->createElement('select', 'cargo_id');
        $cargo->setLabel('Cargo');
        $cargo->setAttrib('class', 'span3 _cargo_id');
        $cargo->setRequired(true);
        $cargo->setOptions(array('multiOptions' => $cargos));
        $this->addElement($cargo);

        // ============================================================================================================
        // Decorators (bootstrap do twitter)
        // ============================================================================================================
        EasyBib_Form_SubFormDecorator::setSubFormDecorator($this);
    }

    public function render(Zend_View_Interface $view = null)
    {
        $id = $this->getElement('id')->getValue();
        $content = '<div class="subform">';
        $content .= '<a id="cargos-' . $id . '" class="close btn" href="#"><span class="icon-trash"></span></a>';
        $content .= parent::render($view);
        $content .= '</div>';
        return $content;
    }

}