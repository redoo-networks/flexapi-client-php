<?php

require_once('login.php');

ini_set('display_errors', 1);
error_reporting(-1);

$customerToken = 'adb0f550e4983daea66b276869289b0876cc9b73';

//$customerToken = $client->loginCustomer('ich@stefanwarnat.de', 'tester');
//var_dump($customerToken);
//exit();

$client = \FlexAPI\Client::getInstance();

$client->enableCustomerMode($customerToken);

$modulObj = new \FlexAPI\Model\Module('HelpDesk');
$listView = new \FlexAPI\Operations\Sea($modulObj);
$listView->setPagesize(10);
$response = $listView->run();

var_dump($response);exit();
//$token = $client->loginCustomer('ich@stefanwarnat.de', 'tester');
var_dump($token);

$modulObj = new \FlexAPI\Model\Module('HelpDesk');
$listView = new \FlexAPI\Operations\ListView($modulObj);
$listView->setPagesize(10);
$result = $listView->run();

$records = $result->getRecords();
echo '<pre>';var_dump($records);
$ticket = $records[0];

//$ticket->createComment();
//$recordObj = $modulObj->getRecord();
