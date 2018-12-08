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
$webhook->setModel($updateWebhookModelId);

$action = new Action("action_move_card_from_list_to_list");
$action->setName('Returns the string \'Executed\'');
$action->addArgument('return', 'Executed');
$action->setFunction(function($return, $data, $action) {
    print_r($data);
    if ($action->getWebhook()->getModel() == $data->listBefore->id) {
        return 'Moved away';
    }
    if ($action->getWebhook()->getModel() == $data->listAfter->id) {
        return 'Moved here';
    }
    return $return;
});

$webhook->setAction($action);

echo $webhook->run($runWebhookJson);
