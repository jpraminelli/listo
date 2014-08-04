<?php

class Noticias_AdminController extends Lib_Controller_Crud
{

    protected $_indexUrl = 'noticias/admin';
    protected $_indexActionTitle = 'Administração de notícias';
    protected $_formActionTitleNew = 'Nova notícia';
    protected $_formActionTitleEdit = 'Editando notícia';
    protected $_usarListaPaginada = true;
    protected $_modelClass = 'Noticias_Model_DbTable_Noticias';
    protected $_formClass = 'Noticias_Form_Noticia';
    protected $_formFilterClass = 'Noticias_Form_Filtros';
    protected $_imagem = null;
    protected $_remover_imagem_atual = null;

    protected function beforeSave(&$values)
    {
        if (isset($values['remover_imagem_atual']) && $values['remover_imagem_atual'] != '') {
            $this->_remover_imagem_atual = (bool) $values['remover_imagem_atual'];
        }

        if (isset($values['imagem']) && is_file(DIR_TEMP . '/' . $values['imagem'])) {
            $this->_imagem = $values['imagem'];
        }
        unset($values['imagem'], $values['remover_imagem_atual']);
    }

    protected function afterSave(&$values)
    {
        if($this->_remover_imagem_atual && is_file(DIR_NOTICIAS . '/' . $values['id'])) {
            unlink(DIR_NOTICIAS . '/' . $values['id']);
        }

        if (isset($this->_imagem) && is_file(DIR_TEMP . '/' . $this->_imagem)) {
            rename(DIR_TEMP . '/' . $this->_imagem, DIR_NOTICIAS . '/' . $values['id']);
            chmod(DIR_NOTICIAS . '/' . $values['id'], 0777);
        }
    }

}