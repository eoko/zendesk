<?php

namespace Eoko\Zendesk\Core;

use SlmQueue\Job\AbstractJob;
use Zendesk\API\Client;

class ZendeskJob extends AbstractJob
{

    /** @var  Client */
    protected $client;

    function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * Execute the job
     *
     * @return void
     */
    public function execute()
    {
        $this->client->ticket()->create($this->getContent());
    }

    /**
     * @param Ticket $value
     * @return \Zend\Stdlib\Message
     */
    public function setContent($value)
    {
        return parent::setContent($value->getArrayCopy()); // TODO: Change the autogenerated stub
    }


}