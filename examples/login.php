<?php
ini_set('display_errors', 1);
error_reporting(-1);

require_once('./config.php');
require_once('../vendor/autoload.php');

$client = \FlexAPI\Client::connect(API_HOSTNAME);

try {
    if(defined('LOGINTOKEN')) {
        $client->setLogintoken(LOGINTOKEN);
    } else {
        $client->login(API_USERNAME, API_PASSWORD);
        echo '<p>Usertoken: '.$client->request()->getLogintoken().'</p>';
    }
} catch (\Exception $exp) {
    echo 'Wrong login';
}

