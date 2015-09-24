<?php
namespace Eoko\Zendesk\Api;

use Eoko\Zendesk\Api\Rest\TicketCollection;
use Eoko\Zendesk\Api\Rest\TicketEntity;
use Eoko\Zendesk\Api\Rest\TicketResource;
use Eoko\Zendesk\Api\Rest\TicketResourceFactory;
use Zend\EventManager\SharedEventManager;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\Hydrator\ArraySerializable;
use ZF\Apigility\Provider\ApigilityProviderInterface;

class Module implements ApigilityProviderInterface
{
    public function getConfig()
    {
        return [
            'service_manager' => array(
                'factories' => array(
                    TicketResource::class => TicketResourceFactory::class,
                ),
            ),
            'router' => array(
                'routes' => array(
                    'eoko.zendesk.api.rest.ticket' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/api/rest/tickets[/:id]',
                            'defaults' => array(
                                'controller' => 'Eoko\Zendesk\Api\Ticket\Rest\Controller',
                            ),
                        ),
                    ),
                ),
            ),
            'zf-versioning' => array(
                'uri' => array(
                    0 => 'eoko.zendesk.api.rest.ticket',
                ),
            ),

            'zf-rest' => array(
                'Eoko\Zendesk\Api\Ticket\Rest\Controller' => array(
                    'listener' => TicketResource::class,
                    'route_name' => 'eoko.zendesk.api.rest.ticket',
                    'route_identifier_name' => 'id',
                    'collection_name' => 'ticket',
                    'entity_http_methods' => array(
                        0 => 'GET',
                    ),
                    'collection_http_methods' => array(
                        0 => 'GET',
                        1 => 'POST',
                    ),
                    'collection_query_whitelist' => array(),
                    'page_size' => 25,
                    'page_size_param' => 'page_size',
                    'entity_class' => TicketEntity::class,
                    'collection_class' => TicketCollection::class,
                    'service_name' => 'Ticket',
                ),
            ),

            'zf-content-negotiation' => array(
                'controllers' => array(
                    'Eoko\Zendesk\Api\Ticket\Rest\Controller' => 'HalJson',
                ),
                'accept_whitelist' => array(
                    'Eoko\Zendesk\Api\Ticket\Rest\Controller' => array(
                        0 => 'application/vnd.eoko.zendesk.api.v1+json',
                        1 => 'application/hal+json',
                        2 => 'application/json',
                    ),
                ),
                'content_type_whitelist' => array(
                    'Eoko\Zendesk\Api\Ticket\Rest\Controller' => array(
                        0 => 'application/vnd.eoko.zendesk.api.v1+json',
                        1 => 'application/json',
                    ),
                ),
            ),
            'zf-hal' => array(
                'renderer' => array(
                    'hydrators' => array(
                        TicketEntity::class => ArraySerializable::class,
                    ),
                ),
                'metadata_map' => array(
                    TicketEntity::class => array(
                        'entity_identifier_name' => 'id',
                        'route_name' => 'eoko.zendesk.api.rest.ticket',
                        'route_identifier_name' => 'id',
                        'hydrator' => 'Zend\Stdlib\Hydrator\ArraySerializable',
                    ),
                    TicketCollection::class => array(
                        'entity_identifier_name' => 'id',
                        'route_name' => 'eoko.zendesk.api.rest.ticket',
                        'route_identifier_name' => 'id',
                        'is_collection' => true,
                    ),
                ),
            ),
            'zf-content-validation' => array(
                'Eoko\Zendesk\Api\Ticket\Rest\Controller' => array(
                    'input_filter' => 'Eoko\Zendesk\Api\Ticket\Rest\Validator',
                ),
            ),
            'input_filter_specs' => array(
                'Eoko\Zendesk\Api\Ticket\Rest\Validator' => array(
                    0 => array(
                        'required' => true,
                        'validators' => array(),
                        'filters' => array(),
                        'name' => 'subject',
                        'description' => 'The ticket subject',
                    ),
                    1 => array(
                        'required' => true,
                        'validators' => array(),
                        'filters' => array(),
                        'name' => 'description',
                        'description' => 'The ticket description',
                    ),
                ),
            ),
            'zf-mvc-auth' => array(
                'authorization' => array(
                    'Eoko\Zendesk\Api\Ticket\Rest\Controller' => array(
                        'collection' => array(
                            'GET' => false,
                            'POST' => false,
                            'PUT' => false,
                            'PATCH' => false,
                            'DELETE' => false,
                        ),
                        'entity' => array(
                            'GET' => false,
                            'POST' => false,
                            'PUT' => false,
                            'PATCH' => false,
                            'DELETE' => false,
                        ),
                    ),
                ),
            ),
        ];
    }
}
