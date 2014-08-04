<?php

class Eventos_Form_Evento extends Lib_Form
{

    protected $_attribs = array(
        'id' => 'Eventos_Form_Evento',
        'class' => 'form-horizontal'
    );

    public function init()
    {
        /*
         * Nome
         */
        $titulo = $this->createElement('text', 'nome');
        $titulo->setLabel('Nome')
                ->setRequired(true)
                ->setAttrib('class', 'span7')
                ->setAttrib('placeholder', 'Nome')
                ->setAttrib('maxlength', '255')
                ->addValidator('NotEmpty', true)
                ->addValidator('StringLength', false, array('max' => '255'))
                ->addFilters(array('StripTags', 'StringTrim'));
        $this->addElement($titulo);

        /*
         * Ativo
         */
        $ativo = $this->createElement('select', 'ativo');
        $ativo->setLabel('Ativo')
                ->setRequired(true)
                ->setAttrib('class', 'span1')
                ->addValidator('NotEmpty', true)
                ->addMultiOptions(array('1' => 'Sim', '0' => 'Não'));
        $this->addElement($ativo);

        $this->addDisplayGroup(array('nome', 'ativo'), 'dg_linha01');

        /*
         * Descrição
         */
        $descricao = $this->createElement('textarea', 'descricao');
        $descricao->setLabel('Descrição')
                ->setRequired(true)
                ->setAttrib('class', 'input-block-level')
                ->setAttrib('rows', '8')
                ->setAttrib('placeholder', 'Descrição')
                ->addValidator('NotEmpty', true)
                ->addFilters(array('StripTags', 'StringTrim'));
        $this->addElement($descricao);

        /*
         * Data
         */
        $data = $this->createElement('text', 'data');
        $data->setLabel('Data')
                ->setRequired(true)
                ->setAttrib('class', 'span2')
                ->setAttrib('placeholder', 'Data (dd/mm/aaaa)')
                ->addValidator('NotEmpty', true)
                ->addValidator('Date');
        $this->addElement($data);

        /*
         * Imagem
         */
        $config = Lib_Config_Ini::instance();
        $imagem = $this->createElement('file', 'imagem');
        $imagem->setLabel('Imagem')
                ->setRequired(true)
                ->setDestination(DIR_TEMP)
                ->addValidator('NotEmpty', true)
                ->addValidator('Size', false, array('max' => $config->eventos->max_size))
                ->addValidator('Extension', false, array('jpg', 'pjpeg', 'pjpg', 'jpeg', 'png'));
        $this->addElement($imagem);

        if (isset($this->_data['id']) && is_file(DIR_EVENTOS . '/' . $this->_data['id'])) {
            $imagem->setRequired(false)
                    ->removeValidator('NotEmpty');

            $remover_imagem = $this->createElement('select', 'remover_imagem');
            $remover_imagem->setLabel('Remover imagem')
                    ->setRequired(true)
                    ->addValidator('NotEmpty', true)
                    ->addMultiOptions(array('' => 'Não', '1' => 'Sim'));
            $this->addElement($remover_imagem);

            $html = '<a id="imagem_atual" data-toggle="modal" data-remote="false" data-target="#modal-ver" href="image.php?src=' . DIR_EVENTOS . '/' . $this->_data['id'] . '&amp;w=530&amp;h=400&amp;zc=3">' .
                    '<img class="img-polaroid img-rounded" src="image.php?src=' . DIR_EVENTOS . '/' . $this->_data['id'] . '&amp;w=100&amp;h=100&amp;zc=2" />' .
                    '</a>';
            $imagem_atual = new Lib_Form_Element_Html('imagem_atual');
            $imagem_atual->setLabel('Imagem Atual')
                    ->setIgnore(true)
                    ->setValue($html);
            $this->addElement($imagem_atual);
        }

        /*
         * Botões
         */
        $this->addButtons($this->_backUrl);

        EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP, 'Salvar', 'Cancelar');

        $titulo->getDecorator('HtmlTag')
                ->setOption('id', 'titulo-container');

        $ativo->getDecorator('HtmlTag')
                ->setOption('id', 'ativo-container');
    }

}
