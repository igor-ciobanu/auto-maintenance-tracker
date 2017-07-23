<?php

return [
    'router' => [
        'routes' => [
            'markAPI' => [
                'type' => \Zend\Router\Http\Segment::class,
                'options' => [
                    'route'    => '/api/mark[/:id]',
                    'constraints' => [
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => \API\Controller\Mark::class,
                    ],
                ],
            ],
            'modelAPI' => [
                'type' => \Zend\Router\Http\Segment::class,
                'options' => [
                    'route'    => '/api/model[/:id]',
                    'constraints' => [
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => \API\Controller\Model::class,
                    ],
                ],
            ],
            'carAPI' => [
                'type' => \Zend\Router\Http\Segment::class,
                'options' => [
                    'route'    => '/api/car[/:id]',
                    'constraints' => [
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => \API\Controller\Car::class,
                    ],
                ],
            ],
            'carTypeAPI' => [
                'type' => \Zend\Router\Http\Segment::class,
                'options' => [
                    'route'    => '/api/car-type[/:id]',
                    'constraints' => [
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => \API\Controller\CarType::class,
                    ],
                ],
            ],
            'maintenanceTypeAPI' => [
                'type' => \Zend\Router\Http\Segment::class,
                'options' => [
                    'route'    => '/api/maintenance-type[/:id]',
                    'constraints' => [
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => \API\Controller\MaintenanceType::class,
                    ],
                ],
            ],
            'maintenanceRuleAPI' => [
                'type' => \Zend\Router\Http\Segment::class,
                'options' => [
                    'route'    => '/api/maintenance-rule[/:id]',
                    'constraints' => [
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => \API\Controller\MaintenanceRule::class,
                    ],
                ],
            ],
            'maintenanceHistoryAPI' => [
                'type' => \Zend\Router\Http\Segment::class,
                'options' => [
                    'route'    => '/api/maintenance-history[/:id]',
                    'constraints' => [
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => \API\Controller\MaintenanceHistory::class,
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            \API\Controller\Mark::class => \API\Controller\Factory\MarkFactory::class,
            \API\Controller\CarType::class => \API\Controller\Factory\CarTypeFactory::class,
            \API\Controller\MaintenanceType::class => \API\Controller\Factory\MaintenanceTypeFactory::class,
            \API\Controller\MaintenanceRule::class => \API\Controller\Factory\MaintenanceRuleFactory::class,
            \API\Controller\MaintenanceHistory::class => \API\Controller\Factory\MaintenanceHistoryFactory::class,
            \API\Controller\Model::class => \API\Controller\Factory\ModelFactory::class,
            \API\Controller\Car::class => \API\Controller\Factory\CarFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            \API\Service\Mark::class => \API\Service\Factory\MarkFactory::class,
            \API\Service\CarType::class => \API\Service\Factory\CarTypeFactory::class,
            \API\Service\MaintenanceType::class => \API\Service\Factory\MaintenanceTypeFactory::class,
            \API\Service\MaintenanceRule::class => \API\Service\Factory\MaintenanceRuleFactory::class,
            \API\Service\MaintenanceHistory::class => \API\Service\Factory\MaintenanceHistoryFactory::class,
            \API\Service\Model::class => \API\Service\Factory\ModelFactory::class,
            \API\Service\Car::class => \API\Service\Factory\CarFactory::class,
        ],
    ],
    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];
