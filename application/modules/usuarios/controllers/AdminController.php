<?php

class Usuarios_AdminController extends Lib_Controller_Crud
{

    // URL correspondente à listagem
    protected $_indexUrl = 'usuarios/admin';
    // Título da tela de listagem
    protected $_indexActionTitle = 'Administração de usuários';
    // Título da tela de edição (form) quando a operação for a de cadastro de
    // um novo registro
    protected $_formActionTitleNew = 'Novo usuário';
    // Título da tela de edição (form) quando a operação for a de alteração
    // de um novo registro
    protected $_formActionTitleEdit = 'Editando usuário';
    // Define qual método deverá ser chamado no model para carregar a
    // lista: listaPaginada() ou lista()
    protected $_usarListaPaginada = true;
    // Qual a classe correspondente ao model *principal* deste CRUD
    protected $_modelClass = 'Usuarios_Model_DbTable_Usuarios';
    // Qual a classe correspondente ao form de edição dos dados
    protected $_formClass = 'Usuarios_Form_Usuario';
    // Qual a classe correspondente ao form que define os filtros a serem
    // utilizados na listagem
    protected $_formFilterClass = 'Usuarios_Form_Filtros';

    public function init()
    {
        parent::init();
        $this->view->headTitle()->prepend('Usuários');
    }

    // Evento executado logo após o registro ser lido do banco de dados.
    // Este método antecede à carga dos valores no form e é o lugar ideal para
    // formatar os dados.
    protected function afterFind(&$values)
    {
        if ($values['id'] == 1 || $values['id'] == 2) {
            Lib_FlashMessage::info('Este usuário não pode ser alterado.');
            $this->_redirect($this->_backUrl);
        }
    }

	protected function beforeUpdate(&$values)
	{		
        if ($values['id'] == 1 || $values['id'] == 2) {
            Lib_FlashMessage::info('Este usuário não pode ser alterado.');
            $this->_redirect($this->_backUrl);
        }
	}

    // Evento executado antes de gravar os dados no banco de dados.
    // É o local ideal para preparar a informação que veio do form para
    // ser gravada no banco de dados. Aqui vale remover itens do array
    // $values (caso correspondam a elementos que não existem no banco de
    // dados), tratar formato de datas, etc.
    protected function beforeSave(&$values)
    {
        if (!empty($values['senha'])) {
            $values['senha'] = md5($values['senha']);
        } else {
            unset($values['senha']);
        }
    }

    // NOTA: Os métodos para excluir e desativar registros estão no CRUD e
    // normalmente não precisam ser implementados nas subclasses. Contudo,
    // neste caso em particular, existe uma verificação que deve ser realizada
    // e é por isso que existe os overrides abaixo.
    public function excluirAction()
    {
//        $id = (int) $this->_getParam('id', 0);
//        if ($id == 1 || $id == 2) {
//            Lib_FlashMessage::info('Este usuário não pode ser excluído.');
            Lib_FlashMessage::info('Não é possível excluir um usuário!');
            $this->_redirect($this->_backUrl);
//        }
//        parent::excluirAction();
    }

    public function ativarDesativarAction()
    {
        $id = (int) $this->_getParam('id', 0);
        if ($id == 1 || $id == 2) {
            Lib_FlashMessage::info('Este usuário não pode ser desativado.');
            $this->_redirect($this->_backUrl);
        }
        parent::ativarDesativarAction();
    }

}
