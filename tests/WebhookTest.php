<?php
/**
 * File: WebhookTest.php in trello-webhooks-wrapper
 * Author: ___AUTHOR___
 * Date: 30.11.18
 * Version: ___VERSION___
 */

require "vendor/autoload.php";

use \Webhooks\Wrapper\Webhook;

class WebhookTest extends \PHPUnit\Framework\TestCase
{
    public function testWebhook()
    {
        $object = new Webhook();
        $this->assertIsObject($object,"Has to be an object.");
    }

}
