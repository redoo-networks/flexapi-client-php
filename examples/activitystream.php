<?php

require_once('login.php');

ini_set('display_errors', 1);
error_reporting(-1);

//$customerToken = 'adb0f550e4983daea66b276869289b0876cc9b73';

if(defined('CUSTOMERPORTALTOKEN') === false) {
//    $customerToken = $client->loginCustomerByKey('ich@stefanwarnat.de', 'CPKEY');
//    echo '<p>Customerportal Token: '.$customerToken.'</p>';
} else {
//    $customerToken = CUSTOMERPORTALTOKEN;
}

$client = \FlexAPI\Client::getInstance();

$activityStream = new \FlexAPI\Operations\ActivityStream();
$activityStream->getEntriesOfRecord(array(33), array('COMMENT_NEW', 'DOCUMENTS_LINK', 'RECORD_EDIT'));