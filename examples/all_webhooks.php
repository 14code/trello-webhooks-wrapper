<?php
namespace Webhooks\Wrapper;

set_include_path('..');

require "vendor/autoload.php";

require ".config";

$client = new Trello\Client();
$client->authenticate($key, $token, Trello\Client::AUTH_URL_CLIENT_ID);

$trello = new Trello($client);
$webhooks = $trello->getWebhooks($token);

foreach ($webhooks as $webhook) {
    print_r($trello->getWebhook($webhook['id']));
}

