<?php

// ====================================================================================================================
// Application
// ====================================================================================================================

return array(
    // ================================================================================================================
    // ACL
    // ================================================================================================================
    'acl' => array(

        'admin' => array(
            'application.controller.admin',

        ),
    ),
    // ================================================================================================================
    // Controllers
    // ================================================================================================================
    'controllers' => array(
        'invokables' => array(
            'application.controller.admin' => 'Application\Controller\AdminController',
            'application.controller.index' => 'Application\Controller\IndexController',
        ),
    ),
    // ================================================================================================================
    // Navigation
    // ================================================================================================================
    'navigation' => array(
        'default' => array(
            'home' => array(
                'label' => 'Início',
                'route' => 'home',
                'resource' => 'application.controller.admin',
                'order' => -100,
            ),
        ),
    ),
    // ================================================================================================================
    // Router
    // ================================================================================================================
    'router' => array(
        'routes' => array(
            ##################
            ## login usuario
            ##################
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/home',
                    'defaults' => array(
                        'module' => 'admin',
                        'controller' => 'application.controller.admin',
                        'action' => 'index',
                    ),
                ),
            ),
            ##################
            ## admin
            ##################
            'admin' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/admin',
                    'defaults' => array(
                        'module' => 'admin',
                        'controller' => 'application.controller.admin',
                        'action' => 'index',
                    ),
                ),
            ),
            ###################
            ## front-end
            ###################
            'front' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'module' => 'front',
                        'controller' => 'application.controller.index',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    // ================================================================================================================
    // Service manager
    // ================================================================================================================
    'service_manager' => array(
        // ------------------------------------------------------------------------------------------------------------
        // factories
        // ------------------------------------------------------------------------------------------------------------
        'factories' => array(
            'application.navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
        'invokables' => array(
            'application.mailer.application' => 'Application\Mailer\ApplicationMailer',
        ),
    ),
    // ================================================================================================================
    // Session
    // ================================================================================================================
    'session' => array(
        'config' => array(
            'class' => 'Zend\Session\Config\SessionConfig',
            'options' => array(
                // http://framework.zend.com/manual/2.3/en/modules/zend.session.config.html
                'name' => 'projeto_padrao',
                'cookie_lifetime' => 2419200,
                'remember_me_seconds' => 43200, // 43200 (12 horas)
            ),
            'storage' => 'Zend\Session\Storage\SessionArrayStorage',
            'validators' => array(
                'Zend\Session\Validator\RemoteAddr',
                'Zend\Session\Validator\HttpUserAgent',
            ),
        ),
    ),
    // ================================================================================================================
    // Translator (habilitar caso seja necessário incluir arquivos de idioma no package Application)
    // ================================================================================================================
    // 'translator' => array(
    //     'translation_file_patterns' => array(
    //         array(
    //             'type'     => 'gettext',
    //             'base_dir' => __DIR__ . '/../language',
    //             'pattern'  => '%s.mo',
    //         ),
    //     ),
    // ),
    // ================================================================================================================
    // View manager
    // ================================================================================================================
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        // ------------------------------------------------------------------------------------------------------------
        // template map (localização das views dos controller, helpers e widgets)
        // ------------------------------------------------------------------------------------------------------------
        'template_map' => array(
            // --------------------------------------------------------------------------------------------------------
            // Layouts
            // --------------------------------------------------------------------------------------------------------
            'layout/admin' => __DIR__ . '/../view/layout/admin.twig',
            'layout/layout' => __DIR__ . '/../view/layout/layout.twig',
            'layout/internas' => __DIR__ . '/../view/layout/internas.twig',
            // --------------------------------------------------------------------------------------------------------
            // Erros
            // --------------------------------------------------------------------------------------------------------
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
            // --------------------------------------------------------------------------------------------------------
            // Views
            // --------------------------------------------------------------------------------------------------------
            'application/admin/index' => __DIR__ . '/../view/application/admin/index.twig',
            'application/index/index' => __DIR__ . '/../view/application/index/index.twig',
            // --------------------------------------------------------------------------------------------------------
            
            // --------------------------------------------------------------------------------------------------------
            // emails
            // --------------------------------------------------------------------------------------------------------
            'email/template' => __DIR__ . '/../view/emails/template.phtml',
            
        ),
    ),
);
