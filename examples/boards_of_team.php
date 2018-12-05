<?php
namespace Webhooks\Wrapper;

set_include_path('..');

require "vendor/autoload.php";

require ".config";

$client = new Trello\Client();
$client->authenticate($key, $token, Trello\Client::AUTH_URL_CLIENT_ID);

$trello = new Trello($client);
$team = $trello->getTeam($testTeamId);
print_r($team);

$models = $trello->getBoards($team);
print_r($models);
