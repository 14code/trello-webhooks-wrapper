<?php
/**
 * File: ObjectTest.php in trello-webhooks-wrapper
 * Author: ___AUTHOR___
 * Date: 30.11.18
 * Version: ___VERSION___
 */

require "vendor/autoload.php";

use \Webhooks\Wrapper\Item;

class ItemTest extends \PHPUnit\Framework\TestCase
{
    public function testItem()
    {
        $object = new Item();
        $this->markTestSkipped('Have to do this test');
    }

}