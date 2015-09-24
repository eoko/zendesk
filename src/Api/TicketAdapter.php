<?php

namespace Eoko\Zendesk\Api;

use Eoko\Zendesk\Api\Rest\TicketEntity;
use Zend\Paginator\Adapter\AdapterInterface;
use Zend\Stdlib\Hydrator\ObjectProperty;
use Zendesk\API\Client;
use Zendesk\API\Tickets;

class TicketAdapter implements AdapterInterface
{

    /** @var Tickets */
    protected $client;

    protected $count = 0;

    function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * Returns a collection of items for a page.
     *
     * @param  int $offset Page offset
     * @param  int $itemCountPerPage Number of items per page
     * @return array
     */
    public function getItems($offset, $itemCountPerPage)
    {
        $params = ['page' => $offset, 'per_page' => $itemCountPerPage];
        $result = $this->client->findAll($params);
        $this->count = $result->count;

        if (is_array($result->tickets)) {
            $hydrator = new ObjectProperty();

            $tickets = array_map(function ($ticket) use ($hydrator) {
                $array = $hydrator->extract($ticket);
                $ticket = new TicketEntity();
                $ticket->exchangeArray($array);
                return $ticket;
            }, $result->tickets);
        } else {
            $tickets = [];
        }

        return $tickets;

    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     */
    public function count()
    {
        return $this->count;
    }


}