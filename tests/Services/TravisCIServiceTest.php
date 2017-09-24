<?php

/**
 * WebhookManager
 *
 * @author: Luca Agnello <luca@gnello.com>
 */

namespace Gnello\WebhookManager\Tests\Services;

use Gnello\WebhookManager\Services\GithubService;
use Gnello\WebhookManager\Services\ServiceInterface;
use Gnello\WebhookManager\Services\TravisCIService;

/**
 * Class TravisCIServiceTest
 *
 * @package Gnello\WebhookManager\Tests\Services
 */
class TravisCIServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testTravisCIServiceClassIsInstanziable()
    {
        $service = new TravisCIService([]);
        $this->assertInstanceOf(ServiceInterface::class, $service);
    }
}