<?php
require "vendor/autoload.php";

use \Webhooks\Wrapper\Trello;
use \Webhooks\Wrapper\Model;

class TrelloTest extends \PHPUnit\Framework\TestCase
{
    private $trello;
    protected static $trelloI;


    public function init($msg = "")
    {
        if (null == $this->trello)
        require ".config";
        $this->trello = new \Webhooks\Wrapper\Trello($key, $token);
    }

    protected function setUp(): void
    {
    }


    public function teamsProvider()
    {
        $this->init("provider");
        $trello = $this->trello;
        $data = $trello->getTeams();
        $return = [];
        foreach ($data as $tmp) {
            $return[] = [$tmp];
        }
        return $return;
    }

    public function testGetTeams()
    {
        $this->init();
        $trello = $this->trello;
        $this->assertIsArray($trello->getTeams(), "Should return array");
    }

    /**
     * @dataProvider teamsProvider
     */
    public function testTest()
    {
        $this->assertTrue(true);
    }

    /**
     * @dataProvider teamsProvider
     */
    public function testGetTeamsReturnedModels($model)
    {
        //fwrite(STDERR, print_r($model, TRUE));
        $this->assertInstanceOf("Webhooks\Wrapper\Model", $model, "Only Model objects required");
        $this->assertEquals("team", $model->getType(), "Every Model should be of type team");
        $this->assertNotEmpty($model->getId(), "Every Model should have an ID");
        $this->assertNotEmpty($model->getName(), "Every Model should have a name");
    }

    public function boardsProvider()
    {
        $this->init();
        $trello = $this->trello;
        $teams = $trello->getTeams();
        foreach ($teams as $team) {
            if ("Test" == $team->getName()) {
                break;
            }
            $team = null;
        }
        $data = $trello->getBoards($team);
        $return = [];
        foreach ($data as $model) {
            $return[] = [$team, $model];
        }
        return $return;
    }

    /**
     * @dataProvider boardsProvider
     */
    public function testGetBoardsReturnedModels($team, $model)
    {
        //fwrite(STDERR, print_r($team, TRUE));
        //fwrite(STDERR, print_r($model, TRUE));
        $this->assertInstanceOf("Webhooks\Wrapper\Model", $model, "Only Model objects required");
        $this->assertEquals($team->getId(), $model->getParentId(), "Every Model should be child of parent model");
        $this->assertEquals("board", $model->getType(), "Every Model should be of type board");
        $this->assertNotEmpty($model->getId(), "Every Model should have an ID");
        $this->assertNotEmpty($model->getName(), "Every Model should have a name");
    }

    public function testGetLists()
    {
        $this->init();
        $trello = $this->trello;
        $this->assertIsArray($trello->getLists(), "Should return array");
    }

    public function listsProvider()
    {
        $this->init();
        $trello = $this->trello;
        $data = $trello->getLists();
        $list = new Model("Testlist", md5("testlist"), 'list');
        array_push($data, $list);
        return [ $data ];
    }

    /**
     * @dataProvider listsProvider
     */
    public function testGetListsReturnedModels($model)
    {
        $this->assertInstanceOf("Webhooks\Wrapper\Model", $model, "Only Model objects required");
        $this->assertEquals("list", $model->getType(), "Every Model should be of type list");
        $this->assertNotEmpty($model->getId(), "Every Model should have an ID");
        $this->assertNotEmpty($model->getName(), "Every Model should have a name");
    }

}