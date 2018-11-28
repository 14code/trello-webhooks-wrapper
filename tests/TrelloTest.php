<?php
require "vendor/autoload.php";

class TrelloTest extends \PHPUnit\Framework\TestCase
{

    public function testGetTeams()
    {
        require ".config";
        $trello = new \Webhooks\Wrapper\Trello($key, $token);
        $this->assertIsArray($trello->getTeams(), "Should return array");
    }

    public function testGetBoards()
    {
        require ".config";
        $trello = new \Webhooks\Wrapper\Trello($key, $token);
        $this->assertIsArray($trello->getBoards(), "Should return array");
    }

    public function testGetLists()
    {
        require ".config";
        $trello = new \Webhooks\Wrapper\Trello($key, $token);
        $this->assertIsArray($trello->getLists(), "Should return array");
    }

    public function testGetCards()
    {
        require ".config";
        $trello = new \Webhooks\Wrapper\Trello($key, $token);
        $this->assertIsArray($trello->getCards(), "Should return array");
    }

    public function testGetModelsReturnsModels()
    {
        require ".config";
        $trello = new \Webhooks\Wrapper\Trello($key, $token);
        $this->assertContainsOnlyInstancesOf("Webhooks\Wrapper\Model", $trello->getModels(), "Should return array with objects of Model");
    }

}