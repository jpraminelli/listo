<?php

class Eventos_AdminController extends Lib_Controller_Crud
{

    protected $_indexUrl = 'eventos/admin';
    protected $_indexActionTitle = 'Administração de eventos';
    protected $_formActionTitleNew = 'Novo evento';
    protected $_formActionTitleEdit = 'Editando evento';
    protected $_usarListaPaginada = true;
    protected $_modelClass = 'Eventos_Model_DbTable_Eventos';
    protected $_formClass = 'Eventos_Form_Evento';
    protected $_formFilterClass = 'Eventos_Form_Filtros';
    protected $_imagem = null;
    protected $_remover_imagem = null;

    public function init()
    {
        parent::init();

        $this->view->headLink()->appendStylesheet(Eventos_Bootstrap::CSS_PATH);
    }

    protected function afterFind(&$values)
    {
        $values['data'] = $this->_record->fmt_data();
    }

    protected function beforeSave(&$values)
    {
        if (isset($values['imagem']) && is_file(DIR_TEMP . '/' . $values['imagem'])) {
            $this->_imagem = $values['imagem'];
        }

        if (isset($values['remover_imagem']) && (int) $values['remover_imagem'] > 0) {
            $this->_remover_imagem = true;
        }

        unset($values['imagem'], $values['remover_imagem']);
    }

    protected function afterSave(&$values)
    {
        if ($this->_remover_imagem === true && is_file(DIR_EVENTOS . '/' . $values['id'])) {
            unlink(DIR_EVENTOS . '/' . $values['id']);
        }

        if (isset($this->_imagem) && is_file(DIR_TEMP . '/' . $this->_imagem)) {
            rename(DIR_TEMP . '/' . $this->_imagem, DIR_EVENTOS . '/' . $values['id']);
            chmod(DIR_EVENTOS . '/' . $values['id'], 0777);
        }
    }

}