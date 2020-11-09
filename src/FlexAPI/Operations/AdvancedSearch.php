<?php


namespace FlexAPI\Operations;


use FlexAPI\Client;
use FlexAPI\Model\Field;
use FlexAPI\Model\Interfaces\Condition;
use FlexAPI\Model\Module;
use FlexAPI\Model\Record;
use FlexAPI\Operations\Interfaces\Search;

class AdvancedSearch implements Search
{
    private $module;
    private $pagesize = 25;
    private $page = 1;
    private $fields = null;

    /**
     * @var Condition
     */
    private $condition = null;
    private $orderBy = null;
    private $sortOrder = null;

    public function __construct(Module $module)
    {
        $this->module = $module;
    }

    public function setPagesize($pagesize) {
        $this->pagesize = intval($pagesize);
    }

    public function setPage($page) {
        $this->page = intval($page);
    }

    public function setFields($fields) {
        $this->fields = $fields;
    }

    public function setCondition(Condition $condition) {
        $this->condition = $condition;
    }

    public function setOrderByField($field, $direction) {
        $this->orderBy = $field;

        $direction = strtolower($direction);

        $this->sortOrder = ($direction === 'desc' ? 'desc' : 'asc');

    }

    /**
     * @return \FlexAPI\Model\SearchResult
     * @throws \Exception
     */
    public function run() {
        $options = [];
        if(!empty($this->pagesize)) {
            $options['limit'] = $this->pagesize;
        } else {
            $options['limit'] = 30;
        }

        $options['module'] = $this->module->getModuleName();

        if(!empty($this->page)) $options['offset'] = ($this->page - 1) * $options['limit'];
        if(!empty($this->fields)) $options['fields'] = $this->fields;
        if(!empty($this->condition)) $options['condition'] = $this->condition->getConditionsForApi();
        if(!empty($this->orderby)) $options['orderby'] = array($this->orderby => $this->sortOrder);

        $response = Client::getInstance()->request()->get('search/complexe', $options);

        if(!is_array($response)) {
            throw new \Exception($response);
        }

        $resultModel = new \FlexAPI\Model\SearchResult($this);

        $resultModel->setTotalCount($response['total']);

        foreach($response['entries'] as $crmid => $entry) {
            $record = new Record($this->module, $entry['crmid']);
            $record->initData($entry);

            $resultModel->addRecord($record);
        }

        return $resultModel;
    }
}
