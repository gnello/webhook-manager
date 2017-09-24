<?php

/**
 * WebhookManager
 *
 * @author: Luca Agnello <luca@gnello.com>
 */

namespace Gnello\WebhookManager;

use Gnello\WebhookManager\Services\BitbucketService;
use Gnello\WebhookManager\Services\ServiceInterface;

/**
 * Class App
 *
 * @package Gnello\WebhookManager
 */
class App
{
    /**
     * @var array
     */
    private $defaultOptions = [
        'service' => BitbucketService::class,
        'json_decode_assoc' => true
    ];

    /**
     * @var array
     */
    private $options = [];

    /**
     * @var array
     */
    private $callables = [];

    /**
     * @var ServiceInterface
     */
    private $service;

    /**
     * Hook constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = array_merge($this->defaultOptions, $options);
    }

    /**
     * Returns the current service
     *
     * @return ServiceInterface
     * @throws WebhookManagerException
     */
    private function getService()
    {
        $this->service = new $this->options['service']($this->options);

        if (!$this->service instanceof ServiceInterface) {
            throw new WebhookManagerException("Service must be an instance of ServiceInterface.");
        }

        return $this->service;
    }

    /**
     * Adds a callback binded with an event
     *
     * @param string   $event
     * @param callable $callable
     * @return App
     */
    public function add(string $event, callable $callable): App
    {
        $this->callables[$event] = $callable;
        return $this;
    }

    /**
     * Performs the callback associated with the event received
     *
     * @return mixed
     * @throws WebhookManagerException
     */
    public function listen()
    {
        $service = $this->getService();
        $event = $service->getEvent();

        if (isset($this->callables[$event]) && is_callable($this->callables[$event])) {
            return $this->callables[$event]($service);
        }

        throw new WebhookManagerException("Callable not found for the " . $event . " event.");
    }
}

