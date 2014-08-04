<?php

class Usuarios_AdminController extends Lib_Controller_Crud
{

    // URL correspondente � listagem
    protected $_indexUrl = 'usuarios/admin';
    // T�tulo da tela de listagem
    protected $_indexActionTitle = 'Administra��o de usu�rios';
    // T�tulo da tela de edi��o (form) quando a opera��o for a de cadastro de
    // um novo registro
    protected $_formActionTitleNew = 'Novo usu�rio';
    // T�tulo da tela de edi��o (form) quando a opera��o for a de altera��o
    // de um novo registro
    protected $_formActionTitleEdit = 'Editando usu�rio';
    // Define qual m�todo dever� ser chamado no model para carregar a
    // lista: listaPaginada() ou lista()
    protected $_usarListaPaginada = true;
    // Qual a classe correspondente ao model *principal* deste CRUD
    protected $_modelClass = 'Usuarios_Model_DbTable_Usuarios';
    // Qual a classe correspondente ao form de edi��o dos dados
    protected $_formClass = 'Usuarios_Form_Usuario';
    // Qual a classe correspondente ao form que define os filtros a serem
    // utilizados na listagem
    protected $_formFilterClass = 'Usuarios_Form_Filtros';

    public function init()
    {
        parent::init();
        $this->view->headTitle()->prepend('Usu�rios');
    }

    // Evento executado logo ap�s o registro ser lido do banco de dados.
    // Este m�todo antecede � carga dos valores no form e � o lugar ideal para
    // formatar os dados.
    protected function afterFind(&$values)
    {
        if ($values['id'] == 1 || $values['id'] == 2) {
            Lib_FlashMessage::info('Este usu�rio n�o pode ser alterado.');
            $this->_redirect($this->_backUrl);
        }
    }

	protected function beforeUpdate(&$values)
	{		
        if ($values['id'] == 1 || $values['id'] == 2) {
            Lib_FlashMessage::info('Este usu�rio n�o pode ser alterado.');
            $this->_redirect($this->_backUrl);
        }
	}

    // Evento executado antes de gravar os dados no banco de dados.
    // � o local ideal para preparar a informa��o que veio do form para
    // ser gravada no banco de dados. Aqui vale remover itens do array
    // $values (caso correspondam a elementos que n�o existem no banco de
    // dados), tratar formato de datas, etc.
    protected function beforeSave(&$values)
    {
        if (!empty($values['senha'])) {
            $values['senha'] = md5($values['senha']);
        } else {
            unset($values['senha']);
        }
    }

    // NOTA: Os m�todos para excluir e desativar registros est�o no CRUD e
    // normalmente n�o precisam ser implementados nas subclasses. Contudo,
    // neste caso em particular, existe uma verifica��o que deve ser realizada
    // e � por isso que existe os overrides abaixo.
    public function excluirAction()
    {
//        $id = (int) $this->_getParam('id', 0);
//        if ($id == 1 || $id == 2) {
//            Lib_FlashMessage::info('Este usu�rio n�o pode ser exclu�do.');
            Lib_FlashMessage::info('N�o � poss�vel excluir um usu�rio!');
            $this->_redirect($this->_backUrl);
//        }
//        parent::excluirAction();
    }

    public function ativarDesativarAction()
    {
        $id = (int) $this->_getParam('id', 0);
        if ($id == 1 || $id == 2) {
            Lib_FlashMessage::info('Este usu�rio n�o pode ser desativado.');
            $this->_redirect($this->_backUrl);
        }
        parent::ativarDesativarAction();
    }

}
