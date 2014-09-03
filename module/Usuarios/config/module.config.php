<?php

// ====================================================================================================================
// Usuários
// ====================================================================================================================

return array(
    // ================================================================================================================
    // ACL
    // ================================================================================================================
    'acl' => array(
        'admin, itau' => array(
            'usuarios.controller.admin',
        ),
    ),
    // ================================================================================================================
    // Controllers
    // ================================================================================================================
    'controllers' => array(
        'invokables' => array(
            'usuarios.controller.login' => 'Usuarios\Controller\LoginController',
            'usuarios.controller.admin' => 'Usuarios\Controller\AdminController',
        ),
    ),
    // ================================================================================================================
    // Doctrine
    // ================================================================================================================
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Entity'),
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Usuarios\Entity' => __NAMESPACE__ . '_entities'
                ),
            ),
        ),
    ),
    // ================================================================================================================
    // Navigation
    // ================================================================================================================
    'navigation' => array(
        'default' => array(
            'usuarios' => array(
                'label' => 'Usuários',
                'type' => 'uri',
                'order' => 10,
                'pages' => array(
                    'usuarios' => array(
                        'label' => 'Usuários',
                        'route' => 'admin|usuarios',
                        'resource' => 'usuarios.controller.admin',
                        'pages' => array(
                            'form' => array(
                                'visible' => false,
                                'route' => 'admin|usuarios|form',
                            ),
                        ),
                    ),
                ),
            ),
            'logout' => array(
                'label' => 'Sair',
                'route' => 'logout',
                'order' => 999,
            ),
        ),
    ),
    // ================================================================================================================
    // Router
    // ================================================================================================================
    'router' => array(
        'routes' => array(
            /*
             * LOGIN / LOGOUT
             */
            'login' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/login',
                    'defaults' => array(
                        'controller' => 'usuarios.controller.login',
                        'action' => 'login',
                    ),
                ),
            ),
            'logout' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/logout',
                    'defaults' => array(
                        'controller' => 'usuarios.controller.login',
                        'action' => 'logout',
                    ),
                ),
            ),
            /*
             * USUARIOS
             */
            'admin|usuarios' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/admin/usuarios[/:pagina]',
                    'constraints' => array(
                        'pagina' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'usuarios.controller.admin',
                        'action' => 'index',
                    ),
                ),
            ),
            'admin|usuarios|form' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/admin/usuarios/form[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'usuarios.controller.admin',
                        'action' => 'form',
                    ),
                ),
            ),
            'admin|usuarios|visivel' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/admin/usuarios/visivel[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'usuarios.controller.admin',
                        'action' => 'visivel',
                    ),
                ),
            ),
            'admin|usuarios|excluir' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/admin/usuarios/excluir[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'usuarios.controller.admin',
                        'action' => 'excluir',
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
        // invokables
        // ------------------------------------------------------------------------------------------------------------
        'invokables' => array(
            'usuarios.form.login' => 'Usuarios\Form\LoginForm',
            'usuarios.form.usuario' => 'Usuarios\Form\UsuarioForm',
            'usuarios.form.usuario_search' => 'Usuarios\Form\UsuarioSearchForm',

            'usuarios.mailer.usuarios' => 'Usuarios\Mailer\UsuariosMailer',
            'usuarios.service.usuarios' => 'Usuarios\Service\UsuariosService',
            'usuarios.session.usuarios' => 'Usuarios\Session\UsuariosSession',
        ),
    ),
    // ================================================================================================================
    // View helpers
    // ================================================================================================================
    'view_helpers' => array(
        'invokables' => array(
            'nomeUsuarioLogado' => 'Usuarios\View\Helper\NomeUsuarioLogado',
        ),
    ),
    // ================================================================================================================
    // View manager
    // ================================================================================================================
    'view_manager' => array(
        // ------------------------------------------------------------------------------------------------------------
        // template map (localização das views dos controller, helpers e widgets)
        // ------------------------------------------------------------------------------------------------------------
        'template_map' => array(
            'usuarios/login/login' => __DIR__ . '/../view/usuarios/login/login.twig',
            
            // USUARIOS
            'usuarios/admin/index' => __DIR__ . '/../view/usuarios/admin/index.twig',
            'usuarios/admin/form' => __DIR__ . '/../view/usuarios/admin/form.twig',
        ),
    ),
);
