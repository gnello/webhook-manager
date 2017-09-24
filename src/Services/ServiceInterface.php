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
    const BITBUCKET = 'service.bitbucket';
    const GITHUB = 'service.github';
    const TRAVIS_CI = 'service.travis.ci';
    const CUSTOM = 'service.custom';

    /**
     * ServiceInterface constructor.
     *
     * @param array $options
     */
    public function __construct(array $options);

    /**
     * @return array
     */
    public function getHeaders(): array;

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