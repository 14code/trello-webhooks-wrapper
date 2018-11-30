<?php
require "vendor/autoload.php";

use \Webhooks\Wrapper\Model;

class ModelTest extends \PHPUnit\Framework\TestCase
{

    public function modelProvider()
    {
        return [
            [new Model('My test model', '12345678', 'dummy')]
        ];
    }
    /**
     * @dataProvider modelProvider
     */
    public function testModel($dummy)
    {
        $model = new Model($dummy->getName(), $dummy->getId(), $dummy->getType());
        $this->assertEquals($dummy, $model,"Has to be the right object.");
    }
}