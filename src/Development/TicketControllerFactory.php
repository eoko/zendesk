<?php

namespace Eoko\Zendesk\Development;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zendesk\API\HttpClient;

class TicketControllerFactory implements FactoryInterface {
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $client = $serviceLocator->getServiceLocator()->get(HttpClient::class);
        return new TicketController($client->tickets());
    }

}