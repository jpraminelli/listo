<?php

// ====================================================================================================================
// Pontos
// ====================================================================================================================

return array(
    // ================================================================================================================
    // ACL
    // ================================================================================================================
    'acl' => array(
        'admin' => array(
            'noticias.controller.admin',
        ),
    ),
    // ================================================================================================================
    // Controllers
    // ================================================================================================================
    'controllers' => array(
        'invokables' => array(
            'noticias.controller.admin' => 'Noticias\Controller\AdminController',
            'noticias.controller.noticias' => 'Noticias\Controller\NoticiasController',
            'noticias.controller.cadastro' => 'Noticias\Controller\CadastroController',
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
                    'Noticias\Entity' => __NAMESPACE__ . '_entities'
                ),
            ),
        ),
    ),
    // ================================================================================================================
    // Navigation
    // ================================================================================================================
    'navigation' => array(
        'default' => array(
             'noticias' => array(
                 'label' => 'Notícias',
                 'type' => 'uri',
                 'order' => 20,
                 'pages' => array(
                    'noticias' => array(
                        'label' => 'Noticias',
                        'route' => 'admin|noticias',
                        'resource' => 'noticias.controller.admin',
                        'pages' => array(
                            'form' => array(
                                'visible' => false,
                                'route' => 'admin|noticias|form',
                            ),
                        ),
                    ),
                 ),
             ),
        ),
    ),
    // ================================================================================================================
    // Router
    // ================================================================================================================
    'router' => array(
        'routes' => array(
            /*
             * Noticias
             */
            'noticias' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/noticias[/:pagina]',
                    'constraints' => array(
                        'pagina' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'noticias.controller.noticias',
                        'action' => 'index',
                    ),
                ),
            ),
            'cadastro' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/cadastro',
                    'defaults' => array(
                        'module' => 'cadastros',
                        'controller' => 'noticias.controller.cadastro',
                        'action' => 'index',
                    ),
                ),
            ),
            'gera-imagem' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/gera-imagem',
                    'defaults' => array(
                        'module' => 'cadastros',
                        'controller' => 'noticias.controller.cadastro',
                        'action' => 'geraImagem',
                    ),
                ),
            ),
            /*
             * Admin
             */
            'admin|noticias' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/admin/noticias[/:pagina]',
                    'constraints' => array(
                        'pagina' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'noticias.controller.admin',
                        'action' => 'index',
                    ),
                ),
            ),
            'admin|noticias|form' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/admin/noticias/form[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'noticias.controller.admin',
                        'action' => 'form',
                    ),
                ),
            ),
            'admin|noticias|visivel' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/admin/noticias/visivel[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'noticias.controller.admin',
                        'action' => 'visivel',
                    ),
                ),
            ),
            'admin|noticias|excluir' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/admin/noticias/excluir[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'noticias.controller.admin',
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
            'noticias.service.noticias' => 'Noticias\Service\NoticiasService',
            'noticias.form.noticia_search' => 'Noticias\Form\NoticiaSearchForm',

            'noticias.form.noticia' => 'Noticias\Form\NoticiaForm',
            'noticias.form.cadastro' => 'Noticias\Form\CadastroForm',
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
            // Admin
            'noticias/admin/index' => __DIR__ . '/../view/controller/admin/index.twig',
            'noticias/admin/form' => __DIR__ . '/../view/controller/admin/form.twig',
            
            'noticias/noticias/index' => __DIR__ . '/../view/controller/noticias/index.twig',
            'noticias/cadastro/index' => __DIR__ . '/../view/controller/cadastro/index.twig',
        ),
    ),
);
