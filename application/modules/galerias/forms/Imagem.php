<?php

class Galerias_Form_Imagem extends Lib_Form_SubForm
{

    public function init()
    {
        if ($this->_data && isset($this->_data['id'])) {
            $recid = $this->_data['id'];
        } else {
            $recid = 'new_' . time();
        }

        $name = "imagens_{$recid}";
        $this->setName($name);
        $this->setElementsBelongTo("imagens[{$recid}]");

        /*
         * id
         */
        $id = $this->createElement('hidden', 'id');
        $id->setValue($recid);
        $this->addElement($id);

        /*
         * Imagem
         */
        $arquivo = new Zend_Form_Element_File('arquivo');
        $arquivo->setAttrib('id', "imagens-{$recid}-imagens{$recid}arquivo")
                ->setLabel('Nova Imagem')
                ->setMultiFile(1)
                ->setValueDisabled(true)
                ->setRequired(true)
                ->setName("imagens{$recid}arquivo")
                ->setDestination(DIR_TEMP) // o método setDestination() precisa ser usado APÓS o setName() !
                ->addValidator('NotEmpty', true)
                ->addValidator('Size', false, array('max' => Lib_Config_Ini::instance()->galerias->max_size))
                ->addValidator('Extension', false, 'png,jpg,jpeg,pjpg,pjpeg');
        $this->addElement($arquivo);

        /*
         * Remover imagem
         */
        $remover_imagem = new Lib_Form_Element_Html('remover_imagem');
        $remover_imagem->setIgnore(true)
                ->setValue('<a href="javascript:void(0);" class="btn btn-danger btn-remover_imagem" rel="' . $recid . '"><i class="icon-trash"></i></a>');
        $this->addElement($remover_imagem);

        $this->addDisplayGroup(array('id', "imagens{$recid}arquivo", 'remover_imagem'), "dg_imagem_{$recid}", array('class' => 'subform_imagens'));

        /*
         * Decorators (bootstrap do twitter)
         */
        EasyBib_Form_SubFormDecorator::setSubFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP);

        $arquivo->getDecorator('HtmlTag')
                ->setOption('class', 'arquivo control-group');

        $remover_imagem->getDecorator('HtmlTag')
                ->setOption('class', 'remover control-group');
    }

    public function isValid($data)
    {
        return parent::isValid($data);
    }

}