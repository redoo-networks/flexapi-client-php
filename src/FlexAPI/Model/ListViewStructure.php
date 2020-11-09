<?php


namespace FlexAPI\Model;


class ListViewStructure
{
    private $operation = null;
    private $response = null;

    public function __construct(\FlexAPI\Operations\ListViewStructure $operation, $response) {
        $this->response = $response;
        $this->operation = $operation;
    }

    public function getFields() {
        var_dump($this->response);
    }
}
