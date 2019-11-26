<?php

require_once('login.php');

ini_set('display_errors', 1);
error_reporting(-1);

$weekplannerObj = new \FlexAPI\Operations\Weekplanner();
$response = $weekplannerObj->getCurrentPlan(6);

echo '<pre>';
var_dump($response);