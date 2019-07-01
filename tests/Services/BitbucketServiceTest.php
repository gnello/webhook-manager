<?php

/**
 * WebhookManager
 *
 * @author: Luca Agnello <luca@gnello.com>
 */

namespace Gnello\WebhookManager\Tests\Services;

use Gnello\WebhookManager\Services\BitbucketService;
use Gnello\WebhookManager\Services\ServiceInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class BitbucketServiceTest
 *
 * @package Gnello\WebhookManager\Tests\Services
 */
class BitbucketServiceTest extends TestCase
{
    public function testBitbucketServiceClassIsInstanziable()
    {
        $service = new BitbucketService([]);
        $this->assertInstanceOf(ServiceInterface::class, $service);
    }
}