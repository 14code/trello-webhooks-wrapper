<?php
namespace Webhooks\Wrapper;

set_include_path('..');

require "vendor/autoload.php";

require ".config";

$trello = new Trello($key, $token);
$models = $trello->listModels();

print_r($models);
