<?php
require "vendor/autoload.php";

use \Webhooks\Wrapper\Trello;
use \Webhooks\Wrapper\Model;
use \Webhooks\Wrapper\Trello\Client;

class TrelloTest extends \PHPUnit\Framework\TestCase
{
    private $trello;
    protected static $trelloI;


    public function testInit()
    {
        //require ".config";
        //$test = new Client();
        //$apiResultClass = get_class($test->api('organizations'));
        //fwrite(STDERR, print_r($test->api('organizations'), TRUE));
        //$client->authenticate($key, $token, Client::AUTH_URL_CLIENT_ID);
        //fwrite(STDERR, print_r($clientMock->api('organizations'), TRUE));


        //$clientStub = $this->createMock(Client::class);

        //$clientStub->method('api')
            //->will($this->returnValue($apiResultMock));

        $clientMock = $this->getMockBuilder(Client::class)
            ->setMethods(['api'])
            ->getMock();

        //$clientMock->expects($this->any())
            //->method('api')
            //->with($this->equalTo('member'))
            //->will($this->returnValue($apiMemberResultMock));

        $clientMock->expects($this->any())
            ->method('api')
            ->with($this->logicalOr(
                $this->equalTo('boards'),
                $this->equalTo('lists'),
                $this->equalTo('organizations'),
                $this->equalTo('member')
            ))
            ->will($this->returnCallback([$this, 'apiReturnCallback']));
        //->will($this->returnValue($apiOrganizationResultMock));

        $trello = new \Webhooks\Wrapper\Trello($clientMock);

        $this->assertTrue(true);
        return $trello;
    }

    public function apiReturnCallback($api)
    {
        switch ($api) {
            case 'organizations':
                $apiOrganizationResultMock = $this->createMock(Trello\Api\Organization::class);
                $apiOrganizationResultMock->method('show')
                    ->will($this->returnValue([
                        'id' => '5c004b2157cb628ef3fd9362',
                        'displayName' => 'Test',
                        'name' => 'Test']));
                return $apiOrganizationResultMock;
            case 'member';
                $apiMemberResultMock = $this->createMock(\Trello\Api\Member::class);
                $apiMemberResultMock->method('organizations')
                    ->will($this->returnValue([]));
                return $apiMemberResultMock;
            case 'boards';
                $apiBoardResultMock = $this->createMock(\Trello\Api\Board::class);
                $apiBoardResultMock->method('show')
                    ->will($this->returnValue([
                        'id' => '5c004b2d62caae0be7f315a1',
                        'displayName' => 'Test',
                        'name' => 'Test']));

                $apiListResultMock = $this->createMock(\Trello\Api\Board\Cardlists::class);
                $apiListResultMock->method('all')
                    ->will($this->returnValue([]));

                $apiBoardResultMock->method('lists')
                    ->will($this->returnValue($apiListResultMock));
                return $apiBoardResultMock;
            case 'lists';
                $apiListResultMock = $this->createMock(\Trello\Api\Cardlist::class);
                $apiListResultMock->method('show')
                    ->will($this->returnValue([
                        'id' => '5c004b344928b30c0359b44e',
                        'displayName' => 'Test',
                        'name' => 'Test']));
                return $apiListResultMock;
        }
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
        //$trello = $this->testInit();
        //$data = $trello->getTeams();
        $return = [];
        //foreach ($data as $tmp) {
            //$return[] = [$tmp];
        //}
        $return[] = [new Model(
            'Test team', 'test123456', 'team'
        )];
        return $return;
    }

    public function selectTestTeamProvider()
    {
        return  new Model(
            'Test team', 'test123456', 'team'
        );
        $trello = $this->testInit();
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
        $trello = $this->testInit();
        $board = $trello->getBoard($id);
        $this->assertInstanceOf("Webhooks\Wrapper\Model", $board, "Only Model object required");
        $this->assertEquals("board", $board->getType(), "Model should be of type board");
        $this->assertEquals($id, $board->getId(), "Model should have Id $id");
        $this->assertNotEmpty($board->getId(), "Every Model should have an ID");
        $this->assertNotEmpty($board->getName(), "Every Model should have a name");
    }

    public function boardsProvider()
    {
        $team = $this->selectTestTeamProvider();
        return [[$team, new Model(
            'Test board', 'test123456', 'board', $team->getId()
        )]];

        $this->testInit();
        $trello = $this->testInit();
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
        return  new Model(
            'Test board', 'test123456', 'board'
        );
        $this->testInit();
        $trello = $this->testInit();
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
        $this->testInit();
        $trello = $this->testInit();
        $list = $trello->getList($id);
        $this->assertInstanceOf("Webhooks\Wrapper\Model", $list, "Only Model object required");
        $this->assertEquals("list", $list->getType(), "Model should be of type list");
        $this->assertEquals($id, $list->getId(), "Model should have Id $id");
        $this->assertNotEmpty($list->getId(), "Every Model should have an ID");
        $this->assertNotEmpty($list->getName(), "Every Model should have a name");
    }

    public function listsProvider()
    {
        $this->testInit();
        $trello = $this->testInit();
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