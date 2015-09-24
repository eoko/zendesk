<?php

namespace Eoko\Zendesk\Core;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zendesk\API\HttpClient as Client;

class ZendeskJobFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $client = $serviceLocator->getServiceLocator()->get(Client::class);
        return new ZendeskJob($client);
    }

}