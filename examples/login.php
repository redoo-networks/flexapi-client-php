<?php
ini_set('display_errors', 1);
error_reporting(-1);

require_once('../vendor/autoload.php');

$client = \FlexAPI\Client::connect('https://swarnat-test.redoo.cloud/');

try {
    $client->login('admin', 'admin');
} catch (\Exception $exp) {
    echo 'Wrong login';
}

