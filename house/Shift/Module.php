<?php

namespace Shift;

use Zend\Mvc\MvcEvent;
use Shift\Session\Container;
use Zend\Session\SessionManager;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src',
                ),
            ),
        );
    }

    public function onBootstrap(MvcEvent $event)
    {
        $application = $event->getApplication();
        $sm = $application->getServiceManager();
        SM::setServiceManager($application->getServiceManager());

        $translator = $sm->get('translator');
        // // $translator->setLocale('pt_BR');
        // // vd(($translator));
        // $translator->addTranslationFile(
        //     'phpArray',
        //     'resources/languages/pt_BR.php',
        //     'default',
        //     'pt_BR'
        // );
        \Zend\Validator\AbstractValidator::setDefaultTranslator($translator);

        // Define a configuração padrão do number_format do twig
        $twigEnvironment = $sm->get('Twig_Environment');
        $twigEnvironment->getExtension('core')->setNumberFormat(0, ',', '.');
        $this->bootstrapSession($event);
    }

    public function bootstrapSession($event)
    {
        $session = $event->getApplication()
                ->getServiceManager()
                ->get('Zend\Session\SessionManager');
        $session->start();

        $container = new Container('initialized');
        if (!isset($container->init)) {
            $session->regenerateId(true);
            $container->init = 1;
        }
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'db_logger' => function ($sm) {
                    $hoje = date('Ymd');
                    $log = new \Zend\Log\Logger();
                    $writer = new \Zend\Log\Writer\Stream("./logs/db-$hoje.log");
                    $log->addWriter($writer);
                    return $log;
                },
                'Zend\Session\SessionManager' => function ($sm) {
                    $config = $sm->get('config');
                    if (isset($config['session'])) {
                        $session = $config['session'];
                        $sessionConfig = null;
                        if (isset($session['config'])) {
                            $class = isset($session['config']['class']) ? $session['config']['class'] : 'Zend\Session\Config\SessionConfig';
                            $options = isset($session['config']['options']) ? $session['config']['options'] : array();
                            $sessionConfig = new $class();
                            $sessionConfig->setOptions($options);
                        }
                        $sessionStorage = null;
                        if (isset($session['storage'])) {
                            $class = $session['storage'];
                            $sessionStorage = new $class();
                        }
                        $sessionSaveHandler = null;
                        if (isset($session['save_handler'])) {
                            // class should be fetched from service manager since it will require constructor arguments
                            $sessionSaveHandler = $sm->get($session['save_handler']);
                        }
                        $sessionManager = new SessionManager($sessionConfig, $sessionStorage, $sessionSaveHandler);
                        if (isset($session['validators'])) {
                            $chain = $sessionManager->getValidatorChain();
                            foreach ($session['validators'] as $validator) {
                                $validator = new $validator();
                                $chain->attach('session.validate', array($validator, 'isValid'));
                            }
                        }
                    } else {
                        $sessionManager = new SessionManager();
                    }
                    Container::setDefaultManager($sessionManager);
                    return $sessionManager;
                },
            ),
        );
    }

}
