<?php

/**
 * WebhookManager
 *
 * @author: Luca Agnello <luca@gnello.com>
 */

namespace Gnello\WebhookManager\Services;

use Gnello\WebhookManager\WebhookManagerException;

/**
 * Class TravisCIService
 *
 * @link https://docs.travis-ci.com/user/notifications/#Configuring-webhook-notifications
 * @package Gnello\WebhookManager\Services
 */
class TravisCIService implements ServiceInterface
{
    /**
     * @var array
     */
    private $options;

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var mixed
     */
    private $payload;

    /**
     * BitbucketService constructor.
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return string
     * @throws WebhookManagerException
     */
    public function getEvent(): string
    {
        return 'ok';
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        if (!isset($this->payload)) {
            $this->payload = json_decode($_POST['payload']);
        }

        return $this->payload;
    }
}