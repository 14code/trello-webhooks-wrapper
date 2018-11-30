<?php
/**
 * File: Trello.php in trello-webhooks-wrapper
 * Author: ###AUTHOR###
 * Date: 25.11.18
 * Version: ###VERSION###
 */

namespace Webhooks\Wrapper;

use \Webhooks\Wrapper\Trello\Client;

class Trello
{
    private $client;

    public function __construct($key, $token)
    {
        $client = new Client();
        $client->authenticate($key, $token, Client::AUTH_URL_CLIENT_ID);
        $this->client = $client;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getTeams()
    {
        $teams = [];
        $client = $this->getClient();

        $result = $client->api('member')->organizations()->all('me');

        foreach ($result as $entry) {
            $team = new Model($entry['displayName'], $entry['id'], 'team');
            $teams[] = $team;
        }

        return $teams;
    }

    public function getBoards(Model $team)
    {
        $boards = [];
        $client = $this->getClient();

        //$result = $client->api('member')->boards()->all();
        //$result = $client->api('member')->boards()->filter($team->getId(), ['organization']);
        //$result = $client->api('organization')->boards()->filter($team->getId());
        $test = $client->api('organization');
        $result = $client->api('organization')->boards()->all($team->getId());
        //print_r($result);

        foreach ($result as $entry) {
            $board = new Model($entry['name'], $entry['id'], 'board', $entry['idOrganization']);
            print_r($board);
            $boards[] = $board;
            //break;
        }

        return $boards;
    }

    public function getLists()
    {
        $lists = [];
        return $lists;
    }

}