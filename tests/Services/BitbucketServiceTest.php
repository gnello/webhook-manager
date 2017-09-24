<?php

/**
 * WebhookManager
 *
 * @author: Luca Agnello <luca@gnello.com>
 */

namespace Gnello\WebhookManager\Tests\Services;

use Gnello\WebhookManager\Services\BitbucketService;
use Gnello\WebhookManager\Services\ServiceInterface;

/**
 * Class BitbucketServiceTest
 *
 * @package Gnello\WebhookManager\Tests\Services
 */
class BitbucketServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testBitbucketServiceClassIsInstanziable()
    {
        $webhookManager = new BitbucketService([]);
        $this->assertInstanceOf(ServiceInterface::class, $webhookManager);
    }
}