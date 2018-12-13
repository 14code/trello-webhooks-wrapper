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

$webhook->addCondition(function($me, $posted) {
    return 'action_move_card_from_list_to_list' == $posted->action->display->translationKey;
});
$webhook->addCondition(function($me, $posted) {
    return $me->getModel() == $posted->action->data->listAfter->id;
});

$action = new Action();

$action->setFunction(function($data) {
    $return = 'Moved card with id ' . $data->card->id . ' to list with id ' . $data->listAfter->id;
    return $return;
});

$webhook->setAction($action);

echo $webhook->run($runWebhookJson);
