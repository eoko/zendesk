<?php
namespace Eoko\Zendesk\Api\Rest;

use Eoko\ODM\DocumentManager\Repository\DocumentManager;
use Mustache\View\Renderer;
use SlmQueue\Queue\QueuePluginManager;
use Zend\Di\ServiceLocator;
use Zend\EventManager\EventManager;
use Zend\EventManager\SharedEventManager;
use Zend\I18n\View\Helper\Translate;
use Zend\Mvc\I18n\Translator;
use Zend\View\Renderer\PhpRenderer;
use Zendesk\API\HttpClient as Client;

class TicketResourceFactory
{
    /**
     * @param ServiceLocator $services
     * @return TicketResource
     */
    public function __invoke($services)
    {
        $api = $services->get(Client::class);
        $client = $api->tickets();

        $queue = $services->get(QueuePluginManager::class);
        $queue = $queue->get('Eoko\Zendesk\Queue\Ticket');

        return new TicketResource($client, $queue);
    }
}
