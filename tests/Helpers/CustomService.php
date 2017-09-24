<?php

/**
 * WebHookManager
 *
 * @author: Luca Agnello <luca@gnello.com>
 */

namespace Gnello\WebHookManager\Tests\Helpers;

use Gnello\WebHookManager\Services\ServiceInterface;

/**
 * Class CustomeService
 *
 * @package Gnello\WebHookManager\Tests
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