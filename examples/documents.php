<?php

require_once('login.php');

ini_set('display_errors', 1);
error_reporting(-1);

$apiOperation = new \FlexAPI\Operations\Documents();
//$response = $apiOperation->getFolders();
/*
$response = $apiOperation->createDocument('assets/dummy.pdf', 'dummy.pdf', array(
	'folderid' => 1,
	'notes_title' => 'Neues Dokument',
	'notecontent' => 'Beschreibung',
));
*/
$response = $apiOperation->updateDocument(25, 'assets/dummy-2.pdf', 'dummy-2.pdf', array(
	'folderid' => 1,
	'notes_title' => 'Neues Dokument '.date('H:i:s'),
	'notecontent' => 'Beschreibung '.date('H:i:s'),
));

echo '<pre>';
var_dump($response);