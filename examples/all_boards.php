<?php
require "vendor/autoload.php";

use Trello\Client;

require ".config";

$client = new Client();
$client->authenticate($key, $token, Client::AUTH_URL_CLIENT_ID);

$boards = $client->api('member')->boards()->all();
//$boards = $client->api('boards')->lists()->all($boardId);

foreach ($boards as $board) {
    print_r($board);
}

