<?php

use Eoko\Zendesk\Core\ZendeskApiClientFactory;
use Eoko\Zendesk\Core\ZendeskJob;
use Eoko\Zendesk\Core\ZendeskJobFactory;
use Zendesk\API\HttpClient as Client;


return [
    'service_manager' => [
        'factories' => [
            Client::class => ZendeskApiClientFactory::class,
        ],
    ],

    'slm_queue' => array(
        'job_manager' => array(
            'factories' => array(
                ZendeskJob::class => ZendeskJobFactory::class,
            ),
        ),

        'queue_manager' => array(
            'factories' => array(
                'Eoko\Zendesk\Queue\Ticket' => 'SlmQueueSqs\Factory\SqsQueueFactory'
            ),
        ),


        'queues' => array(
            'Eoko\Zendesk\Queue\Ticket' => array(
                'queue_url' => 'https://sqs.eu-west-1.amazonaws.com/591955746157/zendesk'
            )
        )
    ),

];
