<?php

require_once('login.php');

ini_set('display_errors', 1);
error_reporting(-1);

$module = new \FlexAPI\Model\Module('HelpDesk');
$record =$module->getRecord(33);

$relatedRecords = $record->getRelatedRecords(
    'Documents',
    array('filename', 'filesize')
);
