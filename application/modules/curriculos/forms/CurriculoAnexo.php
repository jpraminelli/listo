<?php

class Curriculos_Form_CurriculoAnexo extends Lib_Form_SubForm
{

    public function init()
    {
        if ($this->_data && isset($this->_data['id'])) {
            $recid = $this->_data['id'];
        } else {
            $recid = 'new_' . time();
        }
        $name = "anexos_$recid";
        $this->setName($name);
        $this->setElementsBelongTo("anexos[$recid]");

        // ------------------------------------------------------------------------------------------------------------
        // id (hidden)
        // ------------------------------------------------------------------------------------------------------------
        $id = $this->createElement('hidden', 'id');
        $id->removeDecorator('label');
        $id->setValue($recid);
        $this->addElement($id);

        // ------------------------------------------------------------------------------------------------------------
        //TODO: link para o arquivo atual
        // ------------------------------------------------------------------------------------------------------------
        // ...
        // ------------------------------------------------------------------------------------------------------------
        // arquivo (campo file)
        // ------------------------------------------------------------------------------------------------------------
        $arquivo = $this->createElement('file', "anexos{$recid}arquivo");
        $arquivo->setLabel('Arquivo(doc,docx,odt,pdf)');
        $arquivo->setAttrib('class', 'span3');
        // A bizarrice no id (abaixo) é necessária para um workaround em uma limitação do php: http://framework.zend.com/issues/browse/ZF-5864
        $arquivo->setAttrib('id', "anexos-{$recid}-anexos{$recid}arquivo");
        $arquivo->setAttrib('rel', $this->getName());
        $arquivo->addValidator('Extension', false, 'doc,docx,odt,pdf');
        $arquivo->addValidator('Size', false, 2097152); // 1Mb=(1048576) 2Mb=(2097152)
        if (substr($name, 0, 11) == 'anexos_new_') {
            $arquivo->setRequired(true);
        }
        if ($_POST) {
            $arquivo->addFilter(new Zend_Filter_File_Rename(array('target' => Lib_UploadArea::getDir(), 'overwrite' => true)));
        }
        $this->addElement($arquivo);

        // ------------------------------------------------------------------------------------------------------------
        // descrição
        // ------------------------------------------------------------------------------------------------------------
        $descricao = $this->createElement('text', 'descricao');
        $descricao->setLabel('Descrição');
        $descricao->setAttrib('class', 'span3');
        $descricao->setAttrib('maxlength', '255');
        $descricao->setRequired(true);
        $descricao->addFilters(array('StringTrim', 'StripTags'));
        $descricao->addValidator('StringLength', false, array('max' => '255'));
        $this->addElement($descricao);

        // ============================================================================================================
        // Decorators (bootstrap do twitter)
        // ============================================================================================================
        EasyBib_Form_SubFormDecorator::setSubFormDecorator($this);
    }

    public function render(Zend_View_Interface $view = null)
    {
        $id = $this->getElement('id')->getValue();
        $content = '<div class="subform">';
        $content .= '<a id="anexos-' . $id . '" class="close btn" href="#"><span class="icon-trash"></span></a>';
        $content .= parent::render($view);
        $content .= '</div>';
        return $content;
    }

}