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
     * General events
     */
    const PUSH = 'push';
    const PULL_REQUEST = 'pull_request';
    const CRON = 'cron';
    const API = 'api';

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
        return $this->getPayload()['type'];
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        if (!isset($this->payload)) {
            $this->payload = json_decode($_POST['payload'], (bool) $this->options['json_decode_assoc']);
        }

        return $this->payload;
    }
}