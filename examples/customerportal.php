<?php

require_once('login.php');

ini_set('display_errors', 1);
error_reporting(-1);

//$customerToken = 'adb0f550e4983daea66b276869289b0876cc9b73';

if(defined('CUSTOMERPORTALTOKEN') === false) {
    $customerToken = $client->loginCustomerByKey('ich@stefanwarnat.de', 'CPKEY');
    echo '<p>Customerportal Token: '.$customerToken.'</p>';
} else {
    $customerToken = CUSTOMERPORTALTOKEN;
}

$client = \FlexAPI\Client::getInstance();

$client->enableCustomerMode($customerToken);

$modulObj = new \FlexAPI\Model\Module('Contacts');
$record = $modulObj->getRecord(2);
var_dump($record->getData());
$record = $modulObj->getRecord(3);
var_dump($record->getData());

exit();
$listView = new \FlexAPI\Operations\AdvancedSearch($modulObj);
$listView->setPagesize(10);
$listView->setFields(['ticket_title']);
$newCondition = new \FlexAPI\Model\Condition();
$group = $newCondition->addGroup();
//$group->addCondition('ticket_title', 'c', '%Stefan');
$listView->setCondition($newCondition);

$response = $listView->run();

var_dump($response->getTotalCount());
var_dump($response->getRecords());
exit();
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
