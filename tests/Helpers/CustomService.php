<?php

/**
 * WebhookManager
 *
 * @author: Luca Agnello <luca@gnello.com>
 */

namespace Gnello\WebhookManager\Tests\Helpers;

use Gnello\WebhookManager\Services\ServiceInterface;

/**
 * Class CustomeService
 *
 * @package Gnello\WebhookManager\Tests
 */
class CustomService implements ServiceInterface
{
    /**
     * CustomeService constructor.
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        return [];
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return [];
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return 'custom.event';
    }

    /**
     *
     */
    public function getPayload()
    {
    }
}