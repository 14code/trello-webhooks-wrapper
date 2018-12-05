<?php
/**
 * File: Trello.php in trello-webhooks-wrapper
 * Author: ###AUTHOR###
 * Date: 25.11.18
 * Version: ###VERSION###
 */

namespace Webhooks\Wrapper;

use http\Exception;
use \Webhooks\Wrapper\Trello\Client;

class Trello
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getTeam($id)
    {
        $client = $this->getClient();

        $result = $client->api('organizations')->show($id);
        $team = new Model($result['displayName'], $result['id'], 'team');

        return $team;
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

    public function getBoard($id)
    {
        $client = $this->getClient();

        $result = $client->api('boards')->show($id);
        $board = new Model($result['name'], $result['id'], 'board');

        return $board;
    }

    public function getBoards(Model $team)
    {
        $boards = [];
        $client = $this->getClient();

        $result = $client->api('organization')->boards()->all($team->getId());

        foreach ($result as $entry) {
            $board = new Model($entry['name'], $entry['id'], 'board', $entry['idOrganization']);
            $boards[] = $board;
        }

        return $boards;
    }

    public function getList($id)
    {
        $client = $this->getClient();

        $result = $client->api('lists')->show($id);
        $list = new Model($result['name'], $result['id'], 'list');

        return $list;
    }

    public function getLists(Model $board)
    {
        $lists = [];
        $client = $this->getClient();

        $result = $client->api('boards')->lists()->all($board->getId());

        foreach ($result as $entry) {
            $list = new Model($entry['name'], $entry['id'], 'list', $entry['idBoard']);
            $lists[] = $list;
        }

        return $lists;
    }

    public function apiResultFields()
    {
        return [
            'id',
            'displayName',
            'name',
            'idOrganization',
            'idBoard'
        ];
    }

    public function mapApiResult($result)
    {
        $resultFields = $this->apiResultFields();
        $map = [
            'displayName' => 'name',
            'idOrganization' => 'parent',
            'idBoard' => 'parent'
        ];
        $modelFields = [
            'id',
            'name',
            'type',
            'parent'
        ];
        $return = [];
        foreach ($resultFields as $field) {
            if (in_array($field, $modelFields) && isset($result[$field])) {
                $return[$field] = $result[$field];
            }
            if (isset($map[$field]) && isset($result[$field])) {
                $return[$map[$field]] = $result[$field];
            }
        }

        $type = 'team';
        if (isset($result['idOrganization']) && !empty($result['idOrganization'])) {
            $type = 'board';
        }
        if (isset($result['idBoard']) && !empty($result['idBoard'])) {
            $type = 'list';
        }
        $return['type'] = $type;

        if (!isset($return['id']) || !isset($return['name'])) {
            throw new \Exception('Invalid result format');
        }

        return $return;

    }

    public function registerWebhook(Webhook $webhook)
    {
    }

}