<?php

/**
 * WebhookManager
 *
 * @author: Luca Agnello <luca@gnello.com>
 */

namespace Gnello\WebhookManager\Tests\Services;

use Gnello\WebhookManager\Services\GithubService;
use Gnello\WebhookManager\Services\ServiceInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class GithubServiceTest
 *
 * @package Gnello\WebhookManager\Tests\Services
 */
class GithubServiceTest extends TestCase
{
    public function testGithubServiceClassIsInstanziable()
    {
        $service = new GithubService([]);
        $this->assertInstanceOf(ServiceInterface::class, $service);
    }
}