<?php

class Login_Model_Login
{

    /**
     * Verifica no Zend_Auth o login e a senha.
     * 
     * @param string $usuario Nome de usuário.
     * @param string $senha A senha sem nenhum tipo de criptografia.
     * @return boolean Se o login foi ou não bem sucedido.
     */
    public function login($usuario, $senha, $role = null)
    {
        /*
         * Instancia o adaptador;
         */
        $authAdapter = new Zend_Auth_Adapter_DbTable;
        $authAdapter->setTableName('usuarios')
                ->setIdentityColumn('email')
                ->setCredentialColumn('senha')
                ->setCredentialTreatment('MD5(?)');

        /*
         * Seta o login e a senha;
         */
        $authAdapter->setIdentity($usuario)
                ->setCredential($senha);

        /*
         * Chama o Zend_Auth;
         */
        $auth = Zend_Auth::getInstance();

        /*
         * Autentica o resultado (SQL) do adaptador;
         */
        $result = $auth->authenticate($authAdapter);

        /*
         * Procede com o resultado da autenticação
         */
        switch ($result->getCode()) {
            case Zend_Auth_Result::SUCCESS:
                $user = $authAdapter->getResultRowObject(null, array('senha'));
                $auth->getStorage()
                        ->write($user);
                return true;
                break;

            default:
                return false;
                break;
        }
    }

    public function logout()
    {
        Zend_Auth::getInstance()->clearIdentity();
        return;
    }

    public function getIdUsuarioLogado()
    {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $identity = $auth->getIdentity();
            return (int) $identity->id;
        } else {
            return null;
        }
    }

}
