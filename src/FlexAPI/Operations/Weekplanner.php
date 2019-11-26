<?php


namespace FlexAPI\Operations;


use FlexAPI\Client;

class Weekplanner
{
    public function getCurrentPlan($relatedId) {
        $response = Client::getInstance()->request()->get('redooweekplanner/current/' . $relatedId);

        return $response;
    }

}