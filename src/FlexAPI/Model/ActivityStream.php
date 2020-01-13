<?php


namespace FlexAPI\Model;


use FlexAPI\Model\ActivityStream\Entry;

class ActivityStream
{
    /**
     * @var Entry[]
     */
    private $entries = array();

    /**
     * @var \FlexAPI\Operations\ActivityStream
     */
    private $operation = null;

    /**
     * ActivityStream constructor.
     *
     * @param \FlexAPI\Operations\ActivityStream $operation
     */
    public function __construct(\FlexAPI\Operations\ActivityStream $operation)
    {
        $this->operation = $operation;
    }

    /**
     * @param Entry $entry
     */
    public function addEntry(Entry $entry) {
        $this->entries[] = $entry;
    }

    /**
     * @return Entry[]
     */
    public function getEntries() {
        return $this->entries;
    }

    /**
     * @return ActivityStream
     */
    public function nextPage() {
        $page = $this->operation->getPage();

        $this->operation->setPage($page + 1);

        return $this->operation->getEntries();
    }
}