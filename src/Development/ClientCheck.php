<?php
/**
 * Created by PhpStorm.
 * User: merlin
 * Date: 14/09/15
 * Time: 20:32
 */

namespace Eoko\Zendesk\Development;


use ZendDiagnostics\Check\AbstractCheck;
use ZendDiagnostics\Result\Failure;
use ZendDiagnostics\Result\ResultInterface;
use ZendDiagnostics\Result\Success;
use Zendesk\API\Client;

class ClientCheck extends AbstractCheck {

    /** @var Client  */
    protected $client;

    function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * Perform the actual check and return a ResultInterface
     *
     * @return ResultInterface
     */
    public function check()
    {
        try {
            $this->client->settings();
            return new Success();
        } catch (\Exception $e) {
            return new Failure($e->getMessage());
        }
    }

}