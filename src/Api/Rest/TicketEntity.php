<?php
namespace Eoko\Zendesk\Api\Rest;

use Eoko\Zendesk\Api\Entity\CodeEntity;
use Eoko\Zendesk\Api\Entity\UserEntity as User;
use Eoko\Zendesk\Core\Ticket;
use Zend\Crypt\Password\Bcrypt;
use Zend\Stdlib\ArraySerializableInterface;
use Zend\Stdlib\Hydrator\ClassMethods;
use ZF\OAuth2\Adapter\BcryptTrait;
use Eoko\ODM\Metadata\Annotation\Document;
use Eoko\ODM\Metadata\Annotation\KeySchema;

class TicketEntity extends Ticket
{

}