<?php

require_once('login.php');

ini_set('display_errors', 1);
error_reporting(-1);

$moduleObj = new \FlexAPI\Model\Module('Accounts');
$fields = $moduleObj->getFields();

echo '<pre>';
var_dump($fields);
