<?php

/**
 * WebHookManager
 *
 * @author: Luca Agnello <luca@gnello.com>
 */

namespace Gnello\WebHookManager\Tests\Services;

use Gnello\WebHookManager\Services\BitbucketService;
use Gnello\WebHookManager\Services\ServiceInterface;

/**
 * Class BitbucketServiceTest
 *
 * @package Gnello\WebHookManager\Tests\Services
 */
class BitbucketServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testBitbucketServiceClassIsInstanziable()
    {
        $WebHookManager = new BitbucketService([]);
        $this->assertInstanceOf(ServiceInterface::class, $WebHookManager);
    }
}