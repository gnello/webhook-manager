<?php

/**
 * WebhookManager
 *
 * @author: Luca Agnello <luca@gnello.com>
 */

namespace Gnello\WebhookManager\Services;

/**
 * Interface ServiceInterface
 *
 * @package Gnello\WebhookManager\Services
 */
interface ServiceInterface
{
    /**
     * ServiceInterface constructor.
     *
     * @param array $options
     */
    public function __construct(array $options);

    /**
     * Returns the event received from the server
     *
     * @return string
     */
    public function getEvent(): string;

    /**
     * Returns the data received from the server
     *
     * @return mixed
     */
    public function getPayload();
}