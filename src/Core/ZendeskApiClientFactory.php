<?php

namespace Eoko\Zendesk\Core;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zendesk\API\HttpClient as Client;

class ZendeskApiClientFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return Client
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration');
        $client = new Client($config['zendesk']['subdomain'], $config['zendesk']['username']);
        $client->setAuth('basic', ['username' => $config['zendesk']['username'], 'token' => $config['zendesk']['token']]);
        return $client;
    }
}