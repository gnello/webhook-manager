<?php

/**
 * WebhookManager
 *
 * @author: Luca Agnello <luca@gnello.com>
 */

namespace Gnello\WebhookManager\Tests;

use Gnello\WebhookManager\App;
use Gnello\WebhookManager\WebhookManagerException;
use Gnello\WebhookManager\Tests\Helpers\CustomService;
use PHPUnit\Framework\TestCase;

/**
 * Class HookTest
 *
 * @package Gnello\WebhookManager\Tests
 */
class AppTest extends TestCase
{
    public function testAppClassIsInstanziable()
    {
        $webhookManager = new App();
        $this->assertInstanceOf(App::class, $webhookManager);
    }

    public function testWebhookManagerExceptionIsTrownedIfServiceSpecifiedIsNotAClass()
    {
        $webhookManager = new App([
            'service' => 'service.unknown'
        ]);

        $this->expectException(WebhookManagerException::class);

        $webhookManager->listen();
    }

    public function testWebhookManagerExceptionIsTrownedIfServiceSpecifiedIsNotAnInstanceOfServiceInterface()
    {
        $webhookManager = new App([
            'service' => \stdClass::class
        ]);

        $this->expectException(WebhookManagerException::class);

        $webhookManager->listen();
    }

    /**
     * @return App
     */
    public function testCallbackIsAddedAfterAdd()
    {
        $webhookManager = new App(['service' => CustomService::class]);

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
        $this->assertEquals('ok', $webhookManager->listen());
    }

    /**
     * @param App $webhookManager
     * @depends testCallbackIsAddedAfterAdd
     */
    public function testCallbackIsPerformedOnMultipleEvents(App $webhookManager)
    {
        $webhookManager->add(['custom.event', 'custom.event.two'], function() {
            return 'ok';
        });

        $this->assertEquals('ok', $webhookManager->listen());
    }
}