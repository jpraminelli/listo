<?php

namespace Application;

use Shift\AbstractModule;
use Shift\SM;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module extends AbstractModule
{

    protected $__dir__ = __DIR__;
    protected $__namespace__ = __NAMESPACE__;

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'app_logger' => function ($sm) {
                    $hoje = date('Ymd');
                    $log = new \Zend\Log\Logger();
                    $writer = new \Zend\Log\Writer\Stream("./logs/app-$hoje.log");
                    $log->addWriter($writer);
                    return $log;
                },
            ),
        );
    }

    public function onBootstrap(MvcEvent $event)
    {
        $eventManager = $event->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        #########################################################################################
        ## Eventos (quanto mais alta for a prioridade (110 e 100 abaixo), antes será executado).
        #########################################################################################
        
        //$eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, 'forceHttps'), 110);
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, 'checkAcl'), 100);
    }

    public function forceHttps(MvcEvent $event)
    {
        if (APP_ENV == ENV_PRO) {
            $request = $event->getRequest();
            $uri = $request->getUri();
            if ($uri->getScheme() !== 'https') {
                $uri->setScheme('https');
                $response = $event->getResponse();
                $response->getHeaders()->addHeaderLine('Location', $request->getUri());
                return $response;
            }
        }
    }

    public function checkAcl(MvcEvent $event)
    {
        $usuarioLogado = SM::get('usuarios.session.usuarios')->getUsuarioLogado();
        
        if(!$usuarioLogado){
            $usuarioLogado = SM::get('usuarios.session.usuarios')->getPublic();
        }
        
        $matches = $event->getRouteMatch();
        $controller = $matches->getParam('controller');
        // Configuração do ACL
        $acl = SM::get('acl');
        $config = SM::get('config');
        
        $acl->addRole('public');        
        
        // Desconecta o usuário caso o hit seja executado fora do período de atendimento permitido.
        if (isset($config['acl']) && is_array($config['acl'])) {
            foreach ($config['acl'] as $roles => $resources) {
                $roles = explode(',', $roles);

                foreach ($roles as $role) {
                    $role = trim($role);
                    if (!$acl->hasRole($role)) {
                        $acl->addRole($role);
                    }
                    foreach ($resources as $resource) {
                        if (!$acl->hasResource($resource)) {
                            $acl->addResource($resource);
                        }
                    }
                    
                    $acl->allow($role, $resources);
                    $acl->deny('public', $resources);
                }
            }
        }
        
        // Verifica a permissão (se aplicável)
        if (($acl->hasResource($controller) && (!$acl->isAllowed($usuarioLogado->getPerfil(), $controller)))) {        
            $response = $event->getResponse();
            $response->setStatusCode(302);
            $renderer = SM::get('Zend\View\Renderer\PhpRenderer');
            $response->getHeaders()->addHeaderLine('Location', $renderer->plugin('basePath')->__invoke() . '/login');
            return $response;
        }
        
        if ($usuarioLogado) {
            // Relaciona o Acl ao menu de navegação
            \Zend\View\Helper\Navigation\AbstractHelper::setDefaultAcl($acl);
            \Zend\View\Helper\Navigation\AbstractHelper::setDefaultRole($usuarioLogado->getPerfil());
        }
    }

}
