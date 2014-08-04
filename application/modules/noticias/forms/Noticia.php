<?php

class Noticias_Form_Noticia extends Lib_Form
{

    protected $_attribs = array(
        'id' => 'Noticias_Form_Noticia',
        'class' => 'form-horizontal'
    );

    public function init()
    {
        /*
         * Título
         */
        $element = $this->createElement('text', 'titulo');
        $element->setLabel('Título')
                ->setRequired(true)
                ->setAttrib('class', 'span6')
                ->setAttrib('placeholder', 'Título')
                ->addValidator('NotEmpty', true)
                ->addValidator('StringLength', false, array('max' => '255'))
                ->addFilters(array('StripTags', 'StringTrim'));
        $this->addElement($element);

        /*
         * Gravata
         */
        $element = $this->createElement('textarea', 'gravata');
        $element->setLabel('Gravata')
                ->setRequired(true)
                ->setAttrib('class', 'span8')
                ->setAttrib('rows', '2')
                ->setAttrib('placeholder', 'Gravata')
                ->addValidator('NotEmpty', true)
                ->addValidator('StringLength', false, array('max' => '255'))
                ->addFilters(array('StripTags', 'StringTrim'));
        $this->addElement($element);

        /*
         * Texto
         */
        $element = $this->createElement('textarea', 'texto');
        $element->setLabel('Texto')
                ->setRequired(true)
                ->setAttrib('class', 'input-block-level')
                ->setAttrib('rows', '8')
                ->setAttrib('placeholder', 'Texto')
                ->addValidator('NotEmpty', true)
                ->addFilters(array('StripTags', 'StringTrim'));
        $this->addElement($element);

        /*
         * Ativo
         */
        $element = $this->createElement('select', 'ativo');
        $element->setLabel('Ativo')
                ->setRequired(true)
                ->setAttrib('class', 'span1')
                ->addValidator('NotEmpty', true)
                ->addMultiOptions(array('1' => 'Sim', '0' => 'Não'));
        $this->addElement($element);

        /*
         * Imagem
         */
        $this->addHr();

        $imagem = $this->createElement('file', 'imagem');
        $imagem->setLabel('Imagem')
                ->setDestination(DIR_TEMP)
                ->addValidator('Extension', false, array('jpg', 'jpeg', 'pjpg', 'pjpeg', 'png'))
                ->addValidator('Size', false, array('max' => Lib_Config_Ini::instance()->max_size->noticias_imagem));
        $this->addElement($imagem);

        $arr = array('imagem');

        if (isset($this->_data['id']) && is_file(DIR_NOTICIAS . '/' . $this->_data['id'])) {
            $path = DIR_NOTICIAS . '/' . $this->_data['id'];

            $html = '<a id="imagem_atual" href="image.php?src=' . $path . '&amp;w=530&amp;h=400&amp;zc=0" data-target="#modal_imagem" data-toggle="modal" data-remote="false">' .
                    '   <img src="image.php?src=' . $path . '&amp;w=120&amp;h=120&amp;zc=0" class="img-rounded img-polaroid" alt="" title="" width="120" height="120" />' .
                    '</a>';

            $imagem_atual = new Lib_Form_Element_Html('imagem_atual');
            $imagem_atual->setLabel('Imagem atual')
                    ->setValue($html)
                    ->setIgnore(true);
            $this->addElement($imagem_atual);

            $arr[] = 'imagem_atual';

            $this->addDisplayGroup($arr, 'dg_imagem');

            $remover_imagem_atual = $this->createElement('checkbox', 'remover_imagem_atual');
            $remover_imagem_atual->setLabel('Remover imagem atual?');
            $this->addElement($remover_imagem_atual);
        } else {
            $this->addDisplayGroup($arr, 'dg_imagem');
        }

        $this->addHr();

        /*
         * Botões
         */
        $this->addButtons($this->_backUrl);

        EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP, 'Salvar', 'Cancelar');
    }

}