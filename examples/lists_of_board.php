<?php
namespace Webhooks\Wrapper;

set_include_path('..');

require "vendor/autoload.php";

require ".config";

$client = new Trello\Client();
$client->authenticate($key, $token, Trello\Client::AUTH_URL_CLIENT_ID);

$trello = new Trello($client);
$board = $trello->getBoard($testBoardId);
print_r($board);

$models = $trello->getLists($board);
print_r($models);
