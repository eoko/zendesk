<?php

namespace Eoko\Zendesk\Development;

use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\EventManager\SharedEventManager;
use Zend\Mvc\MvcEvent;

class Module {

    public function getConfig()
    {
        return [
            'console' => [
                'router' => [
                    'routes' => [
                        'zendesk.create' => [
                            'options' => [
                                'route' => 'eoko zendesk ticket create',
                                'defaults' => [
                                    'controller' => TicketController::class,
                                    'action' => 'create'
                                ],
                            ],
                        ],
                        'zendesk.list' => [
                            'options' => [
                                'route' => 'eoko zendesk ticket list',
                                'defaults' => [
                                    'controller' => TicketController::class,
                                    'action' => 'list'
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'controllers' => [
                'factories' => [
                    TicketController::class => TicketControllerFactory::class,
                    ClientCheck::class => ClientCheckFactory::class,
                ],
            ],
            'diagnostics' => [
                'Eoko' => [
                    'Zendesk' => ClientCheck::class,
                ]
            ],
        ];
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ ,
                ),
            ),
        );
    }
}
