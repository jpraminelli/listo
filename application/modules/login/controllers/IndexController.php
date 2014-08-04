<?php

class Login_IndexController extends Zend_Controller_Action
{

    private $_loginModel = null;

    const LOGIN_SUCCESS = 'loginSuccess';
    const LOGIN_ERROR = 'loginError';
    const FORM_ERROR = 'formError';

    public function init()
    {
        $this->_loginModel = new Login_Model_Login();

        $this->getHelper('Layout')
                ->setLayout('layout_login');
    }

    public function indexAction()
    {
        $this->_forward('admin');
    }

    public function adminAction()
    {
        $form = new Login_Form_Login();

        if ($this->_request->isPost()) {
            if ($form->isValid($_POST)) {
                $values = $form->getValues();

                if ($this->_loginModel->login($values['login'], $values['senha'])) {
                    //login valido
                    return $this->_redirect('admin');
                } else {
                    Lib_FlashMessage::error('Algo de errado aconteceu!');
                    $this->_redirect('admin');
                }
            } else {
                $form->populate($_POST);
            }
        }
        $this->view->form = $form;
    }

    public function logoutAction()
    {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $identity = $auth->getIdentity();
            $auth->clearIdentity();
        }
        $this->_redirect('login');
    }

    public function alterarSenhaAction()
    {
        $codigo = $this->_getParam('codigo');
        $form = new Login_Form_AlterarSenha;
        $form->populate(array('codigo' => $codigo));

        if ($this->getRequest()->isPost()) {

            if ($form->isValid($_POST)) {
                $values = $form->getValues();
                $usuariosModel = new Login_Model_DbTable_Usuarios;
                $reg = $usuariosModel->fetchRow("codigo = '{$codigo}'");

                if ($reg instanceof Zend_Db_Table_Row_Abstract) {
                    $db = $usuariosModel->getAdapter();
                    $db->beginTransaction();

                    try {
                        $reg->senha = md5($values['senha']);
                        $reg->codigo = null;
                        $reg->save();
                        $db->commit();
                        Lib_FlashMessage::success('Senha alterada com sucesso!');
                        $this->_redirect(WWWROOT . 'login');
                    } catch (Exception $e) {
                        $db->rollBack();

                        if (APPLICATION_ENV != 'production') {
                            Lib_FlashMessage::error('OOPS: ' . $e->getTraceAsString());
                        } else {
                            Lib_FlashMessage::error('Ocorreu um erro. Por favor, tente novamente em alguns instantes.');
                        }
                    }
                } else {
                    Lib_FlashMessage::error('O código é inválido ou está expirado. Por favor, execute os passos da tela "Esqueci minha senha" da página de login para que um novo código seja gerado e enviado por e-mail.');
                }
            } else {
                Lib_FlashMessage::error('Não foi possível redefinir a senha. Por favor, verifique os dados digitados e tente novamente.');
            }
        }
        $this->view->form = $form;
    }

    public function gerarCodigoAction()
    {
        if (!$this->_request->isPost()) {
            return $this->_redirect('login');
        }

        try {
            $email = $this->_getParam('email', '');

            // Valida o e-mail
            $validator = new Zend_Validate_EmailAddress();

            if (!$validator->isValid($email)) {
                Lib_FlashMessage::error('O e-mail digitado não é um endereço válido.');
                $this->_redirect(WWWROOT . 'login');
            }
            $usuarios = new Login_Model_DbTable_Usuarios();
            $usuario = $usuarios->fetchRow("email = '{$email}'");

            if ($usuario instanceof Zend_Db_Table_Row_Abstract) {
                $codigo = md5($usuario->usuario . time());

                $usuario->codigo = $codigo;
                $usuario->save();

                $this->view->usuario = $usuario;
                $this->view->codigo = $codigo;

                $config = Lib_Config_Ini::instance()->emails->from;

                $magicMail = new Lib_Mail();
                $magicMail->enviarEmail($config->address, $config->name, $usuario->email, $usuario->nome, 'Código para recuperação de senha', $this->view->render('index/gerar-codigo.phtml'));
                Lib_FlashMessage::success('Pedido realizado com sucesso. Em breve você receberá um e-mail com instruções e um link para redefinir sua senha.');
            } else {
                Lib_FlashMessage::error("E-mail '<strong>{$email}</strong>' não encontrado.");
            }
        } catch (Exception $e) {
            if (APPLICATION_ENV != 'production') {
                Lib_FlashMessage::error('OOPS: ' . $e->getTraceAsString());
            } else {
                Lib_FlashMessage::error('Ocorreu um erro. Por favor, tente novamente em alguns instantes.');
            }
        }
        $this->_redirect(WWWROOT . 'login');
    }

    private function _response($type, $msg = null, $url = null)
    {
        if ($this->_hasParam('Lib_form')) {
            $this->getHelper('Layout')->disableLayout(true);
            $this->getHelper('ViewRenderer')->setNoRender(true);

            switch ($type) {
                case self::LOGIN_SUCCESS :
                    $response = Lib_Form_Ajax_Response::ok();
                    break;
                case self::LOGIN_ERROR :
                case self::FORM_ERROR :
                default :
                    $response = Lib_Form_Ajax_Response::generalError($msg);
                    break;
            }

            echo $response;
        } else {
            switch ($type) {
                case self::LOGIN_SUCCESS :
                    if ($msg) {
                        Lib_FlashMessage::success($msg);
                    }
                    break;
                case self::LOGIN_ERROR :
                case self::FORM_ERROR :
                default :
                    Lib_FlashMessage::error($msg);
                    break;
            }
            $this->_redirect($url);
        }
    }

}