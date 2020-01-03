<?php
ini_set('display_errors', 1);
error_reporting(-1);

require_once('../vendor/autoload.php');

//$client = \FlexAPI\Client::connect('https://swarnat-test.redoo.cloud/');
//$client = \FlexAPI\Client::connect('http://192.168.11.131/vtiger/dev_env/vtigercrm-weekplaner/');
$client = \FlexAPI\Client::connect('http://192.168.11.131/vtiger/dev_env/vtigercrm-flexxapi/');

try {
    $client->login('admin', 'admin');
} catch (\Exception $exp) {
    echo 'Wrong login';
}

