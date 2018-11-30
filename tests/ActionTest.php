<?php
/**
 * File: ActionTest.php in trello-webhooks-wrapper
 * Author: ___AUTHOR___
 * Date: 30.11.18
 * Version: ___VERSION___
 */

require "vendor/autoload.php";

use \Webhooks\Wrapper\Action;

class ActionTest extends \PHPUnit\Framework\TestCase
{
    public function testObject()
    {
        $object = new Action();
        $this->assertIsObject($object,"Has to be an object.");
    }

}
