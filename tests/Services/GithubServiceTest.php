<?php

/**
 * WebhookManager
 *
 * @author: Luca Agnello <luca@gnello.com>
 */

namespace Gnello\WebhookManager\Tests\Services;

use Gnello\WebhookManager\Services\GithubService;
use Gnello\WebhookManager\Services\ServiceInterface;

/**
 * Class GithubServiceTest
 *
 * @package Gnello\WebhookManager\Tests\Services
 */
class GithubServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testGithubServiceClassIsInstanziable()
    {
        $webhookManager = new GithubService([]);
        $this->assertInstanceOf(ServiceInterface::class, $webhookManager);
    }
}