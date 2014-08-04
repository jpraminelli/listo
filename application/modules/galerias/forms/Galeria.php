<?php

class Galerias_Form_Galeria extends Lib_Form
{

    protected $_attribs = array(
        'id' => 'Galerias_Form_Galeria',
        'class' => 'form-horizontal'
    );

    public function init()
    {
        $request = Zend_Controller_Front::getInstance()->getRequest();

        /*
         * Título
         */
        $titulo = $this->createElement('text', 'titulo');
        $titulo->setLabel('Título')
                ->setRequired(true)
                ->setAttrib('class', 'span7')
                ->setAttrib('placeholder', 'Título')
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

        $this->addDisplayGroup(array('titulo', 'ativo'), 'dg_linha01');

        /*
         * Descrição
         */
        $descricao = $this->createElement('textarea', 'descricao');
        $descricao->setLabel('Descrição')
                ->setRequired(true)
                ->setAttrib('class', 'input-block-level')
                ->setAttrib('rows', '8')
                ->setAttrib('placeholder', 'Texto')
                ->addValidator('NotEmpty', true)
                ->addFilters(array('StripTags', 'StringTrim'));
        $this->addElement($descricao);

        /*
         * Data das fotos
         */
        $data = $this->createElement('text', 'data');
        $data->setLabel('Data das imagens')
                ->setRequired(true)
                ->setAttrib('class', 'span2')
                ->addValidator('NotEmpty', true)
                ->addValidator('Date');
        $this->addElement($data);

        /*
         * Imagens (preview)
         */
        $imagens_preview = $this->createElement('text', 'imagens_preview');
        $imagens_preview->setIgnore(true);
        $this->addElement($imagens_preview);

        /*
         * Total imagens
         */
        $total_imagens = $this->createElement('hidden', 'total_imagens');
        $total_imagens->setRequired(true)
                ->setIgnore(true)
                ->addValidator('Between', false, array(
                    'min' => 1,
                    'max' => Lib_Config_Ini::instance()->galerias->max_files,
                    'inclusive' => true,
                ));
        $translator = clone Zend_Registry::get('translate');
        $translator->addTranslation(array(
            'content' => array(
                Zend_Validate_Between::NOT_BETWEEN => 'Você precisa de no mínimo %min% e no máximo %max% imagens.',
            )
        ));
        $this->addElement($total_imagens);

        /*
         * Imagens
         */
        if ($request->isPost()) {
            if (isset($this->_data, $this->_data['imagens']) && is_array($this->_data['imagens'])) {
                foreach ($this->_data['imagens'] as $id => $imagem) {
                    $imagem['id'] = $id;
                    $form = new Galerias_Form_Imagem($imagem, array('id' => $id));
                    $this->addSubForm($form, $form->getName());
                }
            }
        } else {
            //galeria nova
            $form = new Galerias_Form_Imagem();
            $this->addSubForm($form, $form->getName());
        }

        /*
         * Adicionar imagens
         */
        $adicionar_imagens = new Lib_Form_Element_Html('adicionar_imagens');
        $adicionar_imagens->setIgnore(true)
                ->setValue('<a href="javascript:void(0);" class="btn btn-primary btn-small" id="adicionar_imagens"><i class="icon-white icon-plus"></i> adicionar imagens</a>');
        $this->addElement($adicionar_imagens);

        /*
         * Imagem Principal
         */
        $imagem_principal = $this->createElement('hidden', 'imagem_principal');
        $this->addElement($imagem_principal);

        /*
         * Remover Imagens
         */
        $remover_imagens = $this->createElement('hidden', 'remover_imagens');
        $remover_imagens->setIsArray(true);
        $this->addElement($remover_imagens);

        /*
         * Botões
         */
        $this->addButtons($this->_backUrl);

        EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP, 'Salvar', 'Cancelar');

        $titulo->getDecorator('HtmlTag')
                ->setOption('id', 'titulo-container');

        $ativo->getDecorator('HtmlTag')
                ->setOption('id', 'ativo-container');

        $imagens_preview->addDecorator('ViewScript', array(
            'viewScript' => 'admin/form/imagens_preview.phtml',
            'placement' => false,
            'imagens' => isset($this->_data['imagens']) && $this->_data['imagens'] instanceof Zend_Db_Table_Rowset_Abstract && $this->_data['imagens']->count() > 0 ? $this->_data['imagens'] : array()
        ));

        $adicionar_imagens->getDecorator('HtmlTag')
                ->setOption('id', 'adicionar_imagens-container');

        $remover_imagens->removeDecorator('ViewHelper');
        $total_imagens->removeDecorator('ViewHelper');
    }

    public function isValid($data)
    {
        $total = 0;
        $request = Zend_Controller_Front::getInstance()->getRequest();

        if (isset($data['id'])) {
            $imagensTable = new Galerias_Model_DbTable_Imagens;
            $total += $imagensTable->fetchAll('galerias_id = ' . (int) $data['id'])->count();
        }

        if ($request->isPost()) {
            if (isset($_POST['remover_imagens'])) {
                $total -= count($_POST['remover_imagens']);
            }

            if (isset($_FILES)) {
                foreach ($_FILES as $k => $file) {
                    if (strpos($k, 'imagens') !== false && isset($file['error']) && $file['error'] == 0) {
                        $total++;
                    }
                }
            }
        }

        $data['total_imagens'] = $total;

        return parent::isValid($data);
    }

}