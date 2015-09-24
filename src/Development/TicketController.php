<?php

namespace Eoko\Zendesk\Development;

use Eoko\Zendesk\Core\Ticket;
use Zend\Console\Prompt\Select;
use Zend\Mvc\Controller\AbstractConsoleController;
use Zend\Stdlib\Hydrator\ObjectProperty;
use Zend\Validator\EmailAddress;
use Zendesk\API\Tickets;

class TicketController extends AbstractConsoleController
{
    /** @var  Tickets */
    protected $client;

    function __construct($client)
    {
        $this->client = $client;
    }

    public function listAction()
    {
        $result = $this->client->findAll();
        foreach ($result->tickets as $ticket) {
            $this->message()->show(sprintf(
'Id          : [info]%s[/info]
Subject     : [info]%s[/info]
Description : [info]%s[/info]
------------------------------------------------------------', $ticket->id, $ticket->subject, $ticket->description));
        }
    }

    public function createAction()
    {
        $emailValidator = new EmailAddress();

        $m = $this->message();
        $priorityList = ['urgent', 'high', 'normal', 'low'];
        $typeList = ['problem', 'incident', 'question', 'task'];

        $m->show('[info]What is you subject?[/info]');
        $subject = $this->getConsole()->readLine();

        $m->show('[info]Type[/info]');
        $select = new Select('Which type?', $typeList);
        $type = $typeList[$select->show()];

        $m->show('[info]What is your email?[/info]');
        $email = $this->getConsole()->readLine();

        $m->show('[info]What is your tags (separated by comma)?[/info]');
        $tags = explode(',', $this->getConsole()->readLine());
        $tags = array_map('trim', $tags);

        while (empty($description)) {
            $m->show('[info]What is your description[/info]');
            $description = $this->getConsole()->readLine();
        }

        $m->show('[info]Priority[/info]');
        $select = new Select('Which priority?', $priorityList);
        $priority = $priorityList[$select->show()];

        $extra = [];
        if ($emailValidator->isValid($email)) {
            $extra['requester'] = $email;
        }

        $extra['tags'] = is_array($tags) ? [] : $tags;
        $extra['priority'] = $priority;
        $extra['type'] = $type;

        $e = new Ticket();
        $e->setSubject($subject);
        $e->setDescription($description);
        $e->setExtraFields($extra);

        $result = $this->client->create($e->getArrayCopy());

        if ($result) {
            $e->exchangeArray((new ObjectProperty())->extract($result->ticket));
            return json_encode($e->getArrayCopy(), JSON_PRETTY_PRINT);
        }

        return 0;
    }
}