<?php


namespace FlexAPI\Model;


class ListView
{
    /**
     * @var \FlexAPI\Operations\ListView
     */
    private $operation;

    /**
     * @var Field[]
     */
    private $fields = null;

    /**
     * @var Record[]
     */
    private $entries = [];

    public function __construct(\FlexAPI\Operations\ListView $operation)
    {
        $this->operation = $operation;
    }

    /**
     * @param Field[] $fields
     */
    public function setFields($fields) {
        $this->fields = $fields;
    }

    /**
     * @return Field[]
     */
    public function getFields() {
        return $this->fields;
    }

    /**
     * @param Record $record
     */
    public function addRecord(Record $record) {
        $this->entries[] = $record;
    }

    /**
     * @return Record[]
     */
    public function getRecords() {
        return $this->entries;
    }
}