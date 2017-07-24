<?php

namespace Application;

use Application\Factory\View\Helper\AngularDevelopmentModeFactory;
use Zend\Router\Http\Literal;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'index' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/home',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'admin' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/admin',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
        ],
    ],

    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => ROOT_PATH . '/resources/views/Application/layout/layout.phtml',
            'application/index/index' => ROOT_PATH . '/resources/views/Application/application/index/index.phtml',
            'error/404'               => ROOT_PATH . '/resources/views/Application/error/404.phtml',
            'error/index'             => ROOT_PATH . '/resources/views/Application/error/index.phtml',
        ],
        'template_path_stack' => [
            ROOT_PATH . '/resources/views/Application',
        ],
    ],

    'view_helpers' => [
        'factories' => [
            View\Helper\AngularBuildPathHelper::class => InvokableFactory::class,
            View\Helper\AngularDevelopmentModeHelper::class => AngularDevelopmentModeFactory::class
        ],
        'aliases' => [
            'angularBuildPath' => View\Helper\AngularBuildPathHelper::class,
            'angularDevelopmentMode' => View\Helper\AngularDevelopmentModeHelper::class
        ]
    ],
];
