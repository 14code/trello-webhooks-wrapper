<?php
/**
 * File: ActionTest.php in trello-webhooks-wrapper
 * Author: ___AUTHOR___
 * Date: 30.11.18
 * Version: ___VERSION___
 */

use \Webhooks\Wrapper\Action;

class ActionTest extends \PHPUnit\Framework\TestCase
{
    protected $action;

    public function setUp(): void
    {
    }

    public function testCreateAction()
    {
        $action = new Action();
        $action->setFunction(function($data, $me) {return $data['return'];});
        $this->assertTrue(true);
        return $action;
    }

    /**
     * @depends testCreateAction
     */
    public function testExecute($action)
    {
        $this->assertEquals('Executed', $action->execute([ 'return' => 'Executed']));
    }

    /**
     * @depends testCreateAction
     */
    public function testGetFunction($action)
    {
        $function = $action->getFunction();
        $this->assertInstanceOf('Closure', $function, 'Should return Closure');
    }

    /**
     * @depends testCreateAction
     */
    public function testSetFunction($action)
    {
        $action->setFunction(function() {
            return 'New function';
        });
        $function = $action->getFunction();
        $this->assertEquals('New function', $action->execute());
    }

}
