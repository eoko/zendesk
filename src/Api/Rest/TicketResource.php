<?php
namespace Eoko\Zendesk\Api\Rest;

use Eoko\Zendesk\Api\Entity\CodeEntity;
use Eoko\Mandrill\Struct\MessageStruct;
use Eoko\Mandrill\Struct\RecipientStruct;
use Eoko\ODM\DocumentManager\Repository\DocumentRepository;
use Eoko\Zendesk\Api\TicketAdapter;
use Eoko\Zendesk\Core\ZendeskJob;
use Exception;
use SlmQueue\Queue\QueueAwareInterface;
use SlmQueue\Queue\QueueAwareTrait;
use SlmQueue\Queue\QueueInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\Filter\Encrypt;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\Stdlib\Hydrator\ArraySerializable;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\ObjectProperty;
use Zendesk\API\Tickets;
use ZF\ApiProblem\ApiProblem;
use ZF\MvcAuth\Identity\GuestIdentity;
use ZF\Rest\AbstractResourceListener;
use ZF\Rest\Exception\RuntimeException;
use ZF\Rest\ResourceEvent;

class TicketResource extends AbstractResourceListener implements QueueAwareInterface
{
    use QueueAwareTrait;

    /** @var  Tickets */
    protected $client;

    function __construct($client, $queue)
    {
        $this->client = $client;
        $this->queue = $queue;
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return mixed|ApiProblem
     * @throws Exception
     */
    public function create($data)
    {
        $ticket = new TicketEntity();
        $ticket->exchangeArray($this->getInputFilter()->getValues());

        $job = $this->queue->getJobPluginManager()->get(ZendeskJob::class);
        $job->setContent($ticket);
        return $this->queue->push($job);
    }

    /**
     * Fetch a resource
     *
     * @param mixed $ticket_id
     * @return ApiProblem|TicketEntity
     */
    public function fetch($ticket_id)
    {
        $hydrator = new ObjectProperty();
        $ticket = new TicketEntity();
        $response = $this->client->find($ticket_id);
        $ticket->exchangeArray($hydrator->extract($response->ticket));
        return $ticket;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|TicketCollection
     */
    public function fetchAll($params = array())
    {
        $collection = $this->getCollectionClass();
        $adapter = new TicketAdapter($this->client);
        return new $collection($adapter);
    }

}
