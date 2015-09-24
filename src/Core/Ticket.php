<?php
namespace Eoko\Zendesk\Core;


use Zend\Stdlib\ArraySerializableInterface;

/**
 * Class TicketEvent
 * @package Eoko\Zendesk\Core\Event
 * @see https://developer.zendesk.com/rest_api/docs/core/tickets
 */
class Ticket implements ArraySerializableInterface
{

    protected $id;
    protected $subject = '';
    protected $description = '';
    protected $extra_fields = [];

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     * @return $this
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return array
     */
    public function getExtraFields()
    {
        return $this->extra_fields;
    }

    /**
     * @param array $extra_fields
     * @return $this
     */
    public function setExtraFields(array $extra_fields)
    {
        $this->extra_fields = $extra_fields;
        return $this;
    }

    /**
     * Exchange internal values from provided array
     *
     * @param  array $array
     * @return void
     */
    public function exchangeArray(array $array)
    {
        $this->id           = isset($array['id']) && is_int($array['id'])                       ? $array['id'] : null;
        $this->subject      = isset($array['subject']) && is_string($array['subject'])          ? $array['subject'] : '';
        $this->description  = isset($array['description']) && is_string($array['description'])  ? $array['description'] : '';

        unset($array['description'], $array['subject'], $array['id']);
        $this->extra_fields = $array;
    }

    /**
     * Return an array representation of the object
     *
     * @return array
     */
    public function getArrayCopy()
    {
        $array = [
            'id' => $this->id,
            'subject' => $this->subject,
            'description' => $this->description,
        ];

        return array_merge($array, $this->extra_fields);
    }

}