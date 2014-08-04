<?php

class Galerias_AdminController extends Lib_Controller_Crud
{

    protected $_indexUrl = 'galerias/admin';
    protected $_indexActionTitle = 'Administração de galerias';
    protected $_formActionTitleNew = 'Nova galeria';
    protected $_formActionTitleEdit = 'Editando galeria';
    protected $_usarListaPaginada = true;
    protected $_modelClass = 'Galerias_Model_DbTable_Galerias';
    protected $_formClass = 'Galerias_Form_Galeria';
    protected $_formFilterClass = 'Galerias_Form_Filtros';
    protected $_imagensTable = null;
    protected $_imagem_principal = null;
    protected $_remover_imagens = array();
    protected $_imagens = array();

    public function init()
    {
        parent::init();

        $this->_imagensTable = new Galerias_Model_DbTable_Imagens;
        $this->view->headLink()->appendStylesheet(Galerias_Bootstrap::CSS_PATH);
    }

    protected function afterFind(&$values)
    {
        $values['imagens'] = $this->_record->findDependentRowset('Galerias_Model_DbTable_Imagens');
        $values['data'] = $this->_record->fmt_data();

        $principal = $this->_record->principal();
        $values['imagem_principal'] = $principal instanceof Zend_Db_Table_Row_Abstract ? $principal->id : '';
    }

    protected function beforeSave(&$values)
    {
        if (isset($values['imagem_principal']) && (int) $values['imagem_principal'] > 0) {
            $this->_imagem_principal = $values['imagem_principal'];
        }

        if (isset($values['remover_imagens']) && is_array($values['remover_imagens'])) {
            $this->_remover_imagens = $values['remover_imagens'];
        }

        if (isset($values['imagens'])) {
            $this->_imagens = $values['imagens'];
        }

        unset($values['imagens'], $values['imagem_principal'], $values['remover_imagens']);
    }

    protected function afterSave(&$values)
    {
        if (!is_dir(DIR_GALERIAS . '/' . $values['id'])) {
            mkdir(DIR_GALERIAS . '/' . $values['id'], 0777);
            chmod(DIR_GALERIAS . '/' . $values['id'], 0777);
        }

        foreach ($this->_remover_imagens as $imagem_id) {
            if ((int) $imagem_id > 0) {
                $row = $this->_imagensTable->find($imagem_id)->current();

                if ($row instanceof Zend_Db_Table_Row_Abstract) {
                    $row->delete();
                }
            }
        }

        $transferAdapter = new Zend_File_Transfer_Adapter_Http;

        foreach ($transferAdapter->getFileInfo() as $k => $imagem) {
            $tmp_arr = array(
                'galerias_id' => $values['id'],
                'principal' => 'false'
            );
            $imagem_id = $this->_imagensTable->insert($tmp_arr);

            $path = DIR_GALERIAS . '/' . $values['id'] . '/' . $imagem_id;

            $transferAdapter->addFilter('Rename', DIR_GALERIAS . '/' . $values['id'] . '/' . $imagem_id, $k)
                    ->receive($k);

            chmod($path, 0777);

            if (!(int) $this->_imagem_principal > 0) {
                $this->_imagem_principal = $imagem_id;
            }
        }

        $this->_imagensTable->update(array('principal' => 'false'), 'galerias_id = ' . (int) $values['id']);
        $this->_imagensTable->update(array('principal' => 'true'), array('galerias_id = ' . (int) $values['id'], 'id = ' . (int) $this->_imagem_principal));
    }

}