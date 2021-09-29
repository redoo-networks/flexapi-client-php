<?php

require_once('login.php');

ini_set('display_errors', 1);
error_reporting(-1);

$moduleObj = new \FlexAPI\Model\Module('Quotes');
/*
$fields = array(
    'subject' => 'Test Angebot '.date('Y-m-d H:i:s'),
    'quotestage' => 'Created',
    'taxtype' => 'group',
    'account_id' => 7,
);

$products = array(
    array(
        'productid' => 6,
        'comment' => 'comment',
        'description' => 'description',
        'quantity' => 1,
        'unitprice' => 15,
    ),
    array(
        'productid' => 6,
        'comment' => 'comment',
        'description' => 'description',
        'quantity' => 2,
        'unitprice' => 15,
    ),
    array(
        'productid' => 6,
        'comment' => 'comment',
        'description' => 'description',
        'quantity' => 3,
        'unitprice' => 15,
    ),
);
$tax = array(
    'tax1' => 19
);

$moduleObj->createInventoryRecord($fields, $products, $tax);
*/

$record = $moduleObj->getRecord(14);

$fields = array(
    'subject' => 'Test Angebot-Update '.date('Y-m-d H:i:s'),
    'quotestage' => 'Delivered',
);

$products = array(
    array(
        'productid' => 6,
        'comment' => 'comment',
        'description' => 'description',
        'quantity' => 1,
        'unitprice' => 25,
    ),
    array(
        'productid' => 6,
        'comment' => 'comment',
        'description' => 'description',
        'quantity' => 2,
        'unitprice' => 25,
    ),
);
$tax = array(
    'tax1' => 19
);
$record->updateInventoryRecord($fields, $products, $tax);
var_dump($record);
/*
$record = $moduleObj->createRecord(array(
    'ticket_title' => 'Title',
    'description' => 'Ticket Content',
));
*/
