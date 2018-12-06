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
        $trelloMock = $this->getMockBuilder(\Webhooks\Wrapper\Trello::class)
            ->disableOriginalConstructor()
            ->getMock();

        $webhook = new Webhook($trelloMock);
        $webhook->setAction(new Action("mock"));
        $webhook->setToken('move-to-mock');
        $webhook->setId('123456789');
        $webhook->setModel(new \Webhooks\Wrapper\Model('Mock Model', '123456789', 'mock'));
        $this->webhook = $webhook;
    }

    public function testGetHandle()
    {
        $webhook = $this->webhook;
        $this->assertEquals('move-to-mock', $webhook->getToken());
    }

    public function testSetHandle()
    {
        $webhook = $this->webhook;
        $webhook->setToken('test-the-token');
        $this->assertEquals('test-the-token', $webhook->getToken());
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
