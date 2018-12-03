<?php
/**
 * File: WebhookTest.php in trello-webhooks-wrapper
 * Author: ___AUTHOR___
 * Date: 02.12.18
 * Version: ___VERSION___
 */

use Webhooks\Wrapper\Action;
use Webhooks\Wrapper\Webhook;
use PHPUnit\Framework\TestCase;

class WebhookTest extends TestCase
{
    protected $webhook;

    public function setUp(): void
    {
        $webhook = new Webhook();
        $webhook->setAction(new Action("mock"));
        $webhook->setHandle('move-to-mock');
        $webhook->setId('123456789');
        $webhook->setModel(new \Webhooks\Wrapper\Model('Mock Model', '123456789', 'mock'));
        $this->webhook = $webhook;
    }

    public function testGetHandle()
    {
        $webhook = $this->webhook;
        $this->assertEquals('move-to-mock', $webhook->getHandle());
    }

    public function testSetHandle()
    {
        $webhook = $this->webhook;
        $webhook->setHandle('test-the-handle');
        $this->assertEquals('test-the-handle', $webhook->getHandle());
    }

    public function testSetAction()
    {
        $webhook = $this->webhook;
        $this->markTestSkipped('Have to do this test');
    }

    public function testSetModel()
    {
        $webhook = $this->webhook;
        $this->markTestSkipped('Have to do this test');
    }

    public function testGetModel()
    {
        $webhook = $this->webhook;
        $this->markTestSkipped('Have to do this test');
    }

    public function testSetId()
    {
        $webhook = $this->webhook;
        $this->markTestSkipped('Have to do this test');
    }

    public function testGetAction()
    {
        $webhook = $this->webhook;
        $this->markTestSkipped('Have to do this test');
    }

    public function testGetId()
    {
        $webhook = $this->webhook;
        $this->markTestSkipped('Have to do this test');
    }

    public function testGetUrl()
    {
        $webhook = $this->webhook;
        $this->markTestSkipped('Have to do this test');
    }
}
