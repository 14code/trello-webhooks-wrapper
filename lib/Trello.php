<?php
/**
 * File: Trello.php in trello-webhooks-wrapper
 * Author: ###AUTHOR###
 * Date: 25.11.18
 * Version: ###VERSION###
 */

namespace Webhooks\Wrapper;

use Trello\Client;

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

    public function listModels()
    {
        $models = [];
        $client = $this->getClient();

        // teams
        $teams = $client->api('member')->organizations()->all('me');
        //print_r($teams);
        foreach ($teams as $team) {
            $model = new Model($team['displayName'], $team['id'], 'team');
            $models[] = $model;
        }

        /*
        $boards = $client->api('member')->boards()->all();
        foreach ($boards as $board) {
            $model = new Model($board['name'], $board['id'], 'board');
            $models[] = $model;
        }
        */

        return $models;
    }

}