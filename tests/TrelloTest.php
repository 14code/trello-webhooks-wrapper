<?php
require "vendor/autoload.php";

use \Webhooks\Wrapper\Trello;

class TrelloTest extends \PHPUnit\Framework\TestCase
{
    private $trello;
    protected static $trelloI;


    public function init($msg = "")
    {
        if (null == $this->trello) {
            require ".config";
            $this->trello = new \Webhooks\Wrapper\Trello($key, $token);
        }
    }

    public function testInit()
    {
        require ".config";
        $trello = new \Webhooks\Wrapper\Trello($key, $token);
        $this->assertTrue(true);
        return $trello;
    }

    public function teamIdProvider()
    {
        return [['5c004b2157cb628ef3fd9362']];
    }

    /**
     * @depends testInit
     * @dataProvider teamIdProvider
     */
    public function testGetTeam()
    {
        list($id, $trello) = func_get_args();
        $team = $trello->getTeam($id);
        $this->assertInstanceOf("Webhooks\Wrapper\Model", $team, "Only Model object required");
        $this->assertEquals("team", $team->getType(), "Model should be of type team");
        $this->assertEquals($id, $team->getId(), "Model should have Id $id");
        $this->assertNotEmpty($team->getId(), "Every Model should have an ID");
        $this->assertNotEmpty($team->getName(), "Every Model should have a name");
    }

    public function teamsProvider()
    {
        $this->init();
        $trello = $this->trello;
        $data = $trello->getTeams();
        $return = [];
        foreach ($data as $tmp) {
            $return[] = [$tmp];
        }
        return $return;
    }

    public function selectTestTeamProvider()
    {
        $this->init();
        $trello = $this->trello;
        $teams = $trello->getTeams();
        foreach ($teams as $team) {
            if ("Test" == $team->getName()) {
                return $team;
            }
        }
    }

    /**
     * @depends testInit
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

    public function boardIdProvider()
    {
        return [['5c004b2d62caae0be7f315a1']];
    }

    /**
     * @dataProvider boardIdProvider
     */
    public function testGetBoard($id)
    {
        $this->init();
        $trello = $this->trello;
        $board = $trello->getBoard($id);
        $this->assertInstanceOf("Webhooks\Wrapper\Model", $board, "Only Model object required");
        $this->assertEquals("board", $board->getType(), "Model should be of type board");
        $this->assertEquals($id, $board->getId(), "Model should have Id $id");
        $this->assertNotEmpty($board->getId(), "Every Model should have an ID");
        $this->assertNotEmpty($board->getName(), "Every Model should have a name");
    }

    public function boardsProvider()
    {
        $this->init();
        $trello = $this->trello;
        $team = $this->selectTestTeamProvider();
        $data = $trello->getBoards($team);
        $return = [];
        foreach ($data as $model) {
            $return[] = [$team, $model];
        }
        return $return;
    }

    public function selectTestBoardProvider()
    {
        $this->init();
        $trello = $this->trello;
        $team = $this->selectTestTeamProvider();
        $boards = $trello->getBoards($team);
        foreach ($boards as $board) {
            if ("Test" == $board->getName()) {
                return $board;
            }
        }
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

    public function listIdProvider()
    {
        return [['5c004b344928b30c0359b44e']];
    }

    /**
     * @dataProvider listIdProvider
     */
    public function testGetList($id)
    {
        $this->init();
        $trello = $this->trello;
        $list = $trello->getList($id);
        $this->assertInstanceOf("Webhooks\Wrapper\Model", $list, "Only Model object required");
        $this->assertEquals("list", $list->getType(), "Model should be of type list");
        $this->assertEquals($id, $list->getId(), "Model should have Id $id");
        $this->assertNotEmpty($list->getId(), "Every Model should have an ID");
        $this->assertNotEmpty($list->getName(), "Every Model should have a name");
    }

    public function listsProvider()
    {
        $this->init();
        $trello = $this->trello;
        $board = $this->selectTestBoardProvider();
        $data = $trello->getLists($board);
        $return = [];
        foreach ($data as $model) {
            $return[] = [$model];
        }
        return $return;
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