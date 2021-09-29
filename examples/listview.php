<?php

require_once('login.php');

ini_set('display_errors', 1);
error_reporting(-1);

$client = \FlexAPI\Client::getInstance();

$module = new FlexAPI\Model\Module('Contacts');

$listview = new FlexAPI\Operations\ListViewStructure($module);
//$listview->setCustomViewId(51);
$result = $listview->run();

$result->getFields();
