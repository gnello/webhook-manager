<?php

/**
 * WebhookManager
 *
 * @author: Luca Agnello <luca@gnello.com>
 */

namespace Gnello\WebhookManager\Tests;

use Gnello\WebhookManager\App;
use Gnello\WebhookManager\Services\GithubService;
use Gnello\WebhookManager\WebhookManagerException;
use Gnello\WebhookManager\Services\BitbucketService;
use Gnello\WebhookManager\Services\ServiceInterface;
use Gnello\WebhookManager\Tests\Helpers\CustomService;

/**
 * Class HookTest
 *
 * @package Gnello\WebhookManager\Tests
 */
class AppTest extends \PHPUnit_Framework_TestCase
{
    public function testAppClassIsInstanziable()
    {
        $webhookManager = new App();
        $this->assertInstanceOf(App::class, $webhookManager);
    }

    public function testServiceNotFoundExceptionIsTrownedIfServiceSpecifiedNotExists()
    {
        $webhookManager = new App([
            'service' => 'service.unknown'
        ]);

        $this->expectException(WebhookManagerException::class);
        $this->expectExceptionCode(1001);
        $this->expectExceptionMessage("Service service.unknown not found.");

        $webhookManager->listen();
    }

    public function testCustomServiceIsPresentAfterRegisterCustomService()
    {
        $webhookManager = new App(['service' => ServiceInterface::CUSTOM]);
        $webhookManager->registerCustomService(CustomService::class);

        $this->assertInstanceOf(CustomService::class, $webhookManager->getService());
    }

    /**
     * @return App
     */
    public function testCallbackIsAddedAfterAdd()
    {
        $webhookManager = new App(['service' => ServiceInterface::CUSTOM]);
        $webhookManager->registerCustomService(CustomService::class);

        $webhookManager->add('custom.event', function() {
           return 'ok';
        });

        $this->assertEquals('ok', $webhookManager->listen());
        
        return $webhookManager;
    }

    /**
     * @param App $webhookManager
     * @depends testCallbackIsAddedAfterAdd
     */
    public function testCallbackIsPerformedAfterListen(App $webhookManager)
    {
        $webhookManager = new App(['service' => ServiceInterface::CUSTOM]);
        $webhookManager->registerCustomService(CustomService::class);

        $webhookManager->add('custom.event', function() {
           return 'ok';
        });

        $this->assertEquals('ok', $webhookManager->listen());
    }

    public function testGetServiceReturnsBitbucketServiceIfServiceOptionIsBitbucket()
    {
        $webhookManager = new App(['service' => ServiceInterface::BITBUCKET]);
        $this->assertInstanceOf(BitbucketService::class, $webhookManager->getService());
    }

    public function testGetServiceReturnsGithubServiceIfServiceOptionIsGithub()
    {
        $webhookManager = new App(['service' => ServiceInterface::GITHUB]);
        $this->assertInstanceOf(GithubService::class, $webhookManager->getService());
    }
}