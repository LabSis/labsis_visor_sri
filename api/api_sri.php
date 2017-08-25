<?php

ini_set("display_errors", 1);
require_once './ActionBuilder.php';

$action_str = filter_input(INPUT_GET, "action");
$response = "{}";
if (!is_null($action_str)) {
    $action = ActionBuilder::build($action_str);
    if (!is_null($action)) {
        $action->execute();
        $response = $action->get_result_json();
    }
}
echo $response;
