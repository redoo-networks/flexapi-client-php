<?php


namespace FlexAPI\Model;


use FlexAPI\Operations\Interfaces\Search;

class SearchResult
{
    /**
     * @var \FlexAPI\Operations\Interfaces\Search
     */
    private $operation;

    /**
     * @var int
     */
    private $totalCount = 0;

    /**
     * @var Record[]
     */
    private $entries = [];

    public function __construct(Search $operation)
    {
        $this->operation = $operation;
    }

    public function setTotalCount($totalCount) {
        $this->totalCount = intval($totalCount);
    }
    public function getTotalCount() {
        return $this->totalCount;
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
