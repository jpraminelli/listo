<?php

namespace Usuarios\Controller;

use Shift\SM;
use Usuarios\Entity\Usuario;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class AdminController extends AbstractActionController
{
    private $usuariosService;

    public function __construct()
    {
        $this->usuariosService = SM::get('usuarios.service.usuarios');
    }

    public function indexAction()
    {
       
        $emPesquisa = $this->emPesquisa();
        
        $usuarios = $this->usuariosService->collection($this->params()->fromQuery(), $this->params()->fromRoute('pagina', 1));
        
        $form = SM::get('usuarios.form.usuario_search');
        $form->setData($this->params()->fromQuery());
        
        return array(
            'emPesquisa' => $emPesquisa,
            'tituloGrid' => ($emPesquisa) ? 'Resultado da pesquisa' : 'Todos os registros',
            'quantidade' => $this->usuariosService->count(),
            'form' => $form,
            'usuarios' => $usuarios,
        );
    }

    public function formAction()
    {
        
        $usuario = new Usuario();
        $form = SM::get('usuarios.form.usuario');
        
        if ($this->request->isGet()) {
            $id = (int) $this->params('id');
        } else {
            $id = (int) $this->request->getPost()->id;
        }
        
        if ($id) {
            $usuario = $this->usuariosService->get($id);
            $title = "Editando {$usuario->getNome()}";
        } else {
            $title = 'Novo usuário';
        }
        
        $form->bind($usuario);
        
        if ($this->request->isPost()) {
            
            $retorno = array();
            $post = $this->request->getPost();
            
            // seta os filtros para validacao do form
            $form->setInputFilter($usuario->getInputFilter());

            // seta os campos que deve ser validados, é necesspario informar o CSRF
            if($post['senha']){
                $form->setValidationGroup('id', 'nome', 'login', 'senha', 'visivel', 'validator');
            } else {
                $form->setValidationGroup('id', 'nome', 'login', 'visivel', 'validator');
            }
            
            $form->setData($post);
            
            if ($form->isValid()) {
                
                $usuario->setSenha($post['senha']);
                $usuario->setPerfil('admin');
                                
                $this->usuariosService->save($usuario);
                $this->flash()->success('Operação realizada com sucesso.');
                $this->highlight("tr#row_{$usuario->getId()}");
                $retorno['code'] = 'OK';
            } else {
                $retorno['code'] = 'ERROR';
                $retorno['errors'] = $form->getMessages();
                $retorno['flashError'] = 'Um ou mais erros impedem a gravação dos dados.';
            }
            return new JsonModel($retorno);
        }
        
        $form->prepare();
        
        return array(
            'title' => $title,
            'form' => $form,
            'usuario' => $usuario,
        );
    }
    
    public function visivelAction(){

        $id = (int) $this->params('id');
        $usuario = $this->usuariosService->get($id);

        if(!$usuario->getId() || $usuario->getId() == 1){
            $this->flash()->error('Erro: registro não encontrado!');
            return $this->redirect()->toRoute('usuarios');
        }
        
        // verifica se está ativo
        if($usuario->isVisivel() == 1){
            $usuario->setVisivel(0);
        } else {
            $usuario->setVisivel(1);
        }

        $this->usuariosService->save($usuario);
        $this->flash()->success('Operação realizada com sucesso.');

        return $this->redirect()->toRoute('usuarios');

    }
    
    public function excluirAction(){

        $id = (int) $this->params('id');
        $usuario = $this->usuariosService->get($id);
        
        if(!$usuario->getId() || $usuario->getId() == 1){
            $this->flash()->error('Erro: registro não encontrado!');
            return $this->redirect()->toRoute('usuarios');
        }

        $this->usuariosService->excluir($usuario);
        $this->flash()->success('Operação realizada com sucesso.');

        return $this->redirect()->toRoute('usuarios');

    }

    private function emPesquisa()
    {
        foreach ($this->params()->fromQuery() as $key => $value) {
            if ($value != '') {
                return true;
            }
        }
        return false;
    }
}
