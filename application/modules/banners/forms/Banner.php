<?php

class Banners_Form_Banner extends Lib_Form
{

    protected $_attribs = array(
        'id' => 'Banners_Form_Banner',
        'class' => 'form-horizontal'
    );

    public function init()
    {
        /*
         * Nome
         */
        $nome = $this->createElement('text', 'nome');
        $nome->setLabel('Nome')
                ->setRequired(true)
                ->setAttrib('class', 'span4')
                ->setAttrib('placeholder', 'Nome do banner')
                ->setAttrib('maxlength', '200')
                ->addValidator('NotEmpty', true)
                ->addValidator('StringLength', false, array('max' => '200'))
                ->addFilters(array('StripTags', 'StringTrim'));
        $this->addElement($nome);

        /*
         * ordem
         */
        $ordem = $this->createElement('select', 'ordem');
        $ordem->setLabel('Ordem')
                ->setRequired(true)
                ->setAttrib('class', 'span2')
                ->addFilters(array('StripTags', 'StringTrim'))
                ->addValidator('NotEmpty', true)
                ->addMultiOptions(array('' => 'Selecione', 
                                        '1' => '1',
                                        '2' => '2',
                                        '3' => '3',
                                        '4' => '4',
                                        '5' => '5'));
        $this->addElement($ordem);
        

        /*
         * url
         */
        $element = $this->createElement('text', 'url');
        $element->setLabel('URL')
                ->setRequired(true)
                ->setAttrib('maxlength', '200')
                ->addValidator(new Lib_Validate_Url(), false)
                ->setAttrib('class', 'span6')
                ->addValidator('StringLength', false, array('max' => '200'))
                ->setAttrib('placeholder', 'URL do banner')
                ->addValidator('NotEmpty', true)
                ->addFilters(array('StripTags', 'StringTrim'));
        $this->addElement($element);



        /*
         * Imagem
         */

        $imagem = $this->createElement('file', 'imagem');
        $imagem->setLabel('Imagem')
                ->setRequired(true)
                ->setIgnore(true)
                ->addValidator('Extension', false, array('jpg', 'jpeg', 'pjpg', 'pjpeg', 'png'))
                ->addValidator('Size', false, array('max' => '1MB'));
        $this->addElement($imagem);

        $arr = array('imagem');

        if (isset($this->_data['id']) && is_file(DIR_BANNERS . '/' . md5($this->_data['id']))) {
            $imagem->setRequired(false);
            
            $path = DIR_BANNERS . '/' . md5($this->_data['id']);
            

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