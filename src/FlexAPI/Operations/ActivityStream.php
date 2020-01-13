<?php


namespace FlexAPI\Operations;


use FlexAPI\Client;

class ActivityStream
{
    private $page = 1;
    private $pageSize = 20;
    private $filter = array();

    public function __construct()
    {
        $this->page = 1;
        $this->pageSize = 20;
    }

    public function setPage($page) {
        $this->page = intval($page);
    }
    public function setPagesize($pageSize) {
        $this->pageSize = intval($pageSize);
    }
    public function getPage() {
        return $this->page;
    }

    /**
     * @param $crmId
     * @return \FlexAPI\Model\ActivityStream
     */
    public function getEntriesOfRecord($crmId, $types = array()) {
        $this->clearFilter();

        $this->addFilter(array(
            'type' => $types,
            'crmid' => $crmId,
        ));

        return $this->getEntries();

    }

    public function clearFilter() {
        $this->filter = array();
    }
    public function addFilter($filter) {
        $this->filter[] = $filter;
    }
    /**
     * @param $filter array or arrays
     *      possible keys within inner array:
     *          crmid - array of ids
     *          module - array of record modules
     *          type - array of entry type keys to show
     *
     * @return \FlexAPI\Model\ActivityStream
     */
    public function getEntries() {
        $params = array(
            'offset' => ($this->page - 1) * $this->pageSize,
            'limit' => $this->pageSize,
            'filter' => $this->filter,
        );
        $response = Client::getInstance()->request()->get('timeline/entries', $params);

        return $response;
    }

}