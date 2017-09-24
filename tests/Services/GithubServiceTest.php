<?php

/**
 * WebHookManager
 *
 * @author: Luca Agnello <luca@gnello.com>
 */

namespace Gnello\WebHookManager\Tests\Services;

use Gnello\WebHookManager\Services\GithubService;
use Gnello\WebHookManager\Services\ServiceInterface;

/**
 * Class GithubServiceTest
 *
 * @package Gnello\WebHookManager\Tests\Services
 */
class GithubServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testGithubServiceClassIsInstanziable()
    {
        $WebHookManager = new GithubService([]);
        $this->assertInstanceOf(ServiceInterface::class, $WebHookManager);
    }
}