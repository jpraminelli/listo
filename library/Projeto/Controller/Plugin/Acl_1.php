<?php

class Projeto_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{

    const USER_ADMIN = 'A';
    const USER_VISITANTE = 'V';

    protected static $_roles = array(
        self::USER_ADMIN => 'Administrador',
        self::USER_VISITANTE => 'Visitante',
    );
    protected $_resources = array(
        'default' => array(
            'admin',
        ),
        'noticias' => array(
            'admin',
        ),
        'eventos' => array(
            'admin',
        ),
        'galerias' => array(
            'admin',
        ),
        'usuarios' => array(
            'admin',
        ),
    );
    protected $_allow = array(
        self::USER_ADMIN => array(
            // admin
            'default:admin',
            'noticias:admin',
            'eventos:admin',
            'galerias:admin',
            'usuarios:admin',
        ),
        self::USER_VISITANTE => array()
    );

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $acl = new Zend_Acl();

        $auth = Zend_Auth::getInstance()
                ->setStorage(new Zend_Auth_Storage_Session(APPID . '_AUTH'));

//        if ($request->getModuleName() == 'login') {
//            return;
//        }

        $actualRole = self::getLoggedRole();

        $acl->addRole($actualRole);

        foreach ($this->_resources as $module => $controllers) {
            if (!$acl->has($module)) {
                $acl->add(new Zend_Acl_Resource($module));
            }
            foreach ($controllers as $controller) {
                $acl->addResource(new Zend_Acl_Resource($module . ':' . $controller), $module);
            }
        }

        foreach ($this->_allow[$actualRole] as $permission) {
            $acl->allow($actualRole, $permission);
        }

        $requestedResource = strtolower($request->getModuleName() . ':' . $request->getControllerName());

        if ($acl->has($requestedResource) && !$acl->isAllowed($actualRole, $requestedResource)) {
            if (!($request->getModuleName() == 'login' || $requestedResource == 'default:admin')) {
                Lib_FlashMessage::info('Acesso não permitido.');
            }

            $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');

            if ($request->getModuleName() == 'trabalhe-conosco') {
                $redirectUrl = 'trabalhe-conosco-login.htm';
            } else {
                $redirectUrl = strpos($requestedResource, ':admin') !== false ? 'admin/login' : 'index';
            }

            $redirector->gotoUrl($redirectUrl);
        }

        // Integra o ACL ao Navigation
        $navigation = Zend_Layout::getMvcInstance()
                ->getView()
                ->navigation();

        $navigation->setAcl($acl);
        $navigation->setRole($actualRole);

        Zend_Registry::set('acl', $acl);
    }

    public static function getLoggedRole()
    {
        $auth = Zend_Auth::getInstance();

        if ($auth->hasIdentity()) {
//            $identity = $auth->getIdentity();
//            $role = isset($identity->perfil, self::$_roles[$identity->perfil]) ? $identity->perfil : self::USER_VISITANTE;

            $role = self::USER_ADMIN;
        } else {
            $role = self::USER_VISITANTE;
        }

        return $role;
    }

    public static function getRoleLabel($perfil)
    {
        return isset($perfil, self::$_roles[$perfil]) ? self::$_roles[$perfil] : null;
    }

}