<?php

require_once('login.php');

ini_set('display_errors', 1);
error_reporting(-1);

//$customerToken = $client->loginCustomerByKey('ich@stefanwarnat.de', 'CPKEY');
$client->enableCustomerMode('2964373b75ca82e8262a2c15786142d198e153ca');

$moduleObj = new \FlexAPI\Model\Module('HelpDesk');

$record = $moduleObj->createRecord(array(
    'ticket_title' => 'Title',
    'description' => 'Ticket Content',
));