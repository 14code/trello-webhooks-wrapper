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
        $serviceMock = $this->getMockBuilder(\Webhooks\Wrapper\Trello::class)
            ->disableOriginalConstructor()
            ->setMethods(['getWebhook'])
            ->getMock();

        $serviceMock->expects($this->any())
            ->method('getWebhook')
            ->with($this->equalTo('test-the-token'))
            ->will($this->returnValue(['active' => true, 'idModel' => 'id-from-service',
                'description' => 'description from service', 'callbackURL' => 'url-from-service']));

        $webhook = new Webhook($serviceMock);
        $webhook->setAction(new Action("mock"));
        $webhook->setToken('move-to-mock');
        $webhook->setId('123456789');
        $webhook->setModel(new \Webhooks\Wrapper\Model('Mock Model', '123456789', 'mock'));
        $this->webhook = $webhook;
    }

    public function testGetToken()
    {
        $webhook = $this->webhook;
        $this->assertEquals('move-to-mock', $webhook->getToken());
    }

    public function testSetToken()
    {
        $webhook = $this->webhook;
        $webhook->setToken('test-the-token');
        $this->assertEquals('test-the-token', $webhook->getToken());
        return $webhook;
    }

    /**
     * @depends testSetToken
     */
    public function testPullFromService($webhook)
    {
        $webhook->pullFromService();
        $this->assertEquals('description from service', $webhook->getDescription());

    }

}
