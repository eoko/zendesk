<?php
/**
 * Created by PhpStorm.
 * User: merlin
 * Date: 14/09/15
 * Time: 20:32
 */

namespace Eoko\Zendesk\Development;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZendDiagnostics\Check\AbstractCheck;
use ZendDiagnostics\Result\ResultInterface;
use Zendesk\API\Client;

class ClientCheckFactory implements FactoryInterface {
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $client = $serviceLocator->get(Client::class);
        return new ClientCheck($client);
    }


}