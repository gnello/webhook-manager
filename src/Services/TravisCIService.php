<?php

/**
 * WebHookManager
 *
 * @author: Luca Agnello <luca@gnello.com>
 */

namespace Gnello\WebHookManager\Services;

use Gnello\WebHookManager\WebHookManagerException;

/**
 * Class TravisCIService
 *
 * @link https://docs.travis-ci.com/user/notifications/#Configuring-webhook-notifications
 * @package Gnello\WebHookManager\Services
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
     * @throws WebHookManagerException
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