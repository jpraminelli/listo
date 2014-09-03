<?php

namespace Usuarios\Controller;

use Shift\SM;
use Usuarios\Service\UsuariosService;
use Usuarios\Service\UsuariosSession;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController
{

    /** @var UsuariosService */
    private $usuariosService;

    /** @var UsuariosSession */
    private $usuariosSession;

    public function __construct()
    {
        $this->usuariosService = SM::get('usuarios.service.usuarios');
        $this->usuariosSession = SM::get('usuarios.session.usuarios');
    }

    public function loginAction()
    {
        
        $form = SM::get('usuarios.form.login');

        if ($this->request->isPost()) {
            $usuario = null;
            $retorno = array();
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $prms = $form->getData();
                $usuario = $this->usuariosService->login($prms['usuario']['login'], $prms['usuario']['senha']);
            }

            if (is_object($usuario) ) {
                $this->usuariosSession->setUsuarioLogado($usuario);
                // Registra uma log do login do usuário
                $logger = SM::get('app_logger');
                $logger->info("LOGIN: {$usuario->getId()} ({$usuario->getLogin()}).");
                //
                $this->flash()->info("Bem vindo, {$usuario->getNome()}.");
                $retorno['code'] = 'OK';
                
                $retorno['forwardTo'] = $this->url()->fromRoute('home');
                
            } else {
                $retorno['code'] = 'ERROR';
                $retorno['errors'] = $form->getMessages();
                $retorno['flashError'] = isset($usuario['erro']) ? $usuario['erro'] : 'Não foi possível realizar o login.';
            }
            return new JsonModel($retorno);
        }
        $this->usuariosSession->clearUsuarioLogado();
        $form->prepare();
        $viewModel = new ViewModel(array('form' => $form));
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function logoutAction()
    {
        $this->usuariosSession->clearUsuarioLogado();
        return $this->redirect()->toRoute('login');
    }

}
