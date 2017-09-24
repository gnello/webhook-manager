<?php

/**
 * WebHookManager
 *
 * @author: Luca Agnello <luca@gnello.com>
 */

namespace Gnello\WebHookManager\Tests;

use Gnello\WebHookManager\App;
use Gnello\WebHookManager\WebHookManagerException;
use Gnello\WebHookManager\Services\BitbucketService;
use Gnello\WebHookManager\Services\ServiceInterface;
use Gnello\WebHookManager\Tests\Helpers\CustomService;

/**
 * Class HookTest
 *
 * @package Gnello\WebHookManager\Tests
 */
class AppTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $webHookManager = new App();
        $this->assertInstanceOf(App::class, $webHookManager);
    }

    public function testServiceNotFoundExceptionIsTrowned()
    {
        $webHookManager = new App([
            'service' => 'service.unknown'
        ]);

        $this->expectException(WebHookManagerException::class);
        $this->expectExceptionCode(1001);
        $this->expectExceptionMessage("Service service.unknown not found.");

        $webHookManager->listen();
    }

    public function testCustomServiceIsPresentAfterRegisterCustomService()
    {
        $webHookManager = new App(['service' => ServiceInterface::CUSTOM]);
        $webHookManager->registerCustomService(CustomService::class);

        $this->assertInstanceOf(CustomService::class, $webHookManager->getService());
    }

    /**
     * @return App
     */
    public function testCallbackIsAddedAfterAdd()
    {
        $webHookManager = new App(['service' => ServiceInterface::CUSTOM]);
        $webHookManager->registerCustomService(CustomService::class);

        $webHookManager->add('custom.event', function() {
           return 'ok';
        });

        $this->assertEquals('ok', $webHookManager->listen());
        
        return $webHookManager;
    }

    /**
     * @param App $webHookManager
     * @depends testCallbackIsAddedAfterAdd
     */
    public function testCallbackIsPerformedAfterListen(App $webHookManager)
    {
        $webHookManager = new App(['service' => ServiceInterface::CUSTOM]);
        $webHookManager->registerCustomService(CustomService::class);

        $webHookManager->add('custom.event', function() {
           return 'ok';
        });

        $this->assertEquals('ok', $webHookManager->listen());
    }

    public function testGetBitBucketService()
    {
        $webHookManager = new App(['service' => ServiceInterface::BITBUCKET]);
        $this->assertInstanceOf(BitbucketService::class, $webHookManager->getService());
    }
}