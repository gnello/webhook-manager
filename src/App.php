<?php

/**
 * WebhookManager
 *
 * @author: Luca Agnello <luca@gnello.com>
 */

namespace Gnello\WebhookManager;

use Gnello\WebhookManager\Services\BitbucketService;
use Gnello\WebhookManager\Services\GithubService;
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
        'service' => ServiceInterface::BITBUCKET,
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
     * @var array
     */
    private $servicesFactory = [
        ServiceInterface::BITBUCKET => BitbucketService::class,
        ServiceInterface::GITHUB => GithubService::class,
    ];

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
        if (isset($this->servicesFactory[$this->options['service']])) {
            $this->service = new $this->servicesFactory[$this->options['service']]($this->options);
        } else {
            throw new WebhookManagerException("Service " . $this->options['service'] . " not found.", 1001);
        }

        if (!$this->service instanceof ServiceInterface) {
            throw new WebhookManagerException("Service must be an instance of ServiceInterface.", 1003);
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
     * Registers a custom service
     *
     * @param string $fullyQualifiedClassName
     * @return App
     */
    public function registerCustomService(string $fullyQualifiedClassName): App
    {
        $this->servicesFactory[ServiceInterface::CUSTOM] = $fullyQualifiedClassName;
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

        throw new WebhookManagerException("Callable not found for the " . $event . " event.", 1002);
    }
}

