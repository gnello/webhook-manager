<?php

/**
 * WebHookManager
 *
 * @author: Luca Agnello <luca@gnello.com>
 */

namespace Gnello\WebHookManager;

use Gnello\WebHookManager\Services\ServiceInterface;

/**
 * Class Service
 *
 * @package Gnello\WebHookManager
 */
class Service implements ServiceInterface
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

    private $serviceConfig;

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
        $this->headers['X-Event-Key'] = $_SERVER['HTTP_X_EVENT_KEY'];
        $this->headers['X-Hook-UUID'] = $_SERVER['HTTP_X_HOOK_UUID'];
        $this->headers['X-Request-UUID'] = $_SERVER['HTTP_X_REQUEST_UUID'];
        $this->headers['X-Attempt-Number'] = $_SERVER['X_ATTEMPT_NUMBER'];

        foreach ($this->serviceConfig->getHeaders() as $header) {
            $this->headers[$header] = $_SERVER[$header];
        }

        return $this->headers;
    }

    /**
     * @return string
     * @throws WebHookManagerException
     */
    public function getEvent(): string
    {
        if (empty($this->headers)) {
            $this->getHeaders();
        }

        if (!isset($this->headers['X-Event-Key'])) {
            throw new WebHookManagerException("No event specified.");
        }

        return $this->headers['X-Event-Key'];
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        if (!isset($this->payload)) {
            $this->payload = json_decode(file_get_contents('php://input'), (bool) $this->options['json_decode_assoc']);
        }

        return $this->payload;
    }
}