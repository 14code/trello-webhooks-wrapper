<?php
namespace Webhooks\Wrapper;

use http\Exception\RuntimeException;

set_include_path('..');

require "vendor/autoload.php";

require ".config";

$client = new Trello\Client();
$client->authenticate($key, $token, Trello\Client::AUTH_URL_CLIENT_ID);

$trello = new Trello($client);

$webhook = new Webhook($trello);
$webhook->setToken($getWebhookToken);

$webhook->pullFromService();

$webhook->setUrl($updateWebhookNewUrl . $webhook->getId());
$webhook->setModel($updateWebhookModelId);

$webhook->pushToService();

$webhook->pullFromService();

$webhook->setService(null);
print_r($webhook);
