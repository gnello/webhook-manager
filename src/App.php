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
     * App constructor.
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
        $className = $this->options['service'];
        if (class_exists($className)) {
            $this->service = new $className($this->options);
        } else {
            throw new WebhookManagerException("Given class " . $className . " not exists.");
        }

        if (!$this->service instanceof ServiceInterface) {
            throw new WebhookManagerException("Service must be an instance of ServiceInterface.");
        }

        return $this->service;
    }

    /**
     * Adds a callback bound with one or more events
     *
     * @param string|array   $event
     * @param callable       $callable
     * @return App
     */
    public function add($event, callable $callable): App
    {
        if (!is_array($event)) {
            $event = [$event];
        }

        foreach ($event as $e) {
            $this->callables[$e] = $callable;
        }

        return $this;
    }

    /**
     * Performs the callback bound with the event received
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

