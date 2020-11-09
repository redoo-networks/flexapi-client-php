<?php


namespace FlexAPI\Operations;


use FlexAPI\Client;
use FlexAPI\Model\Field;
use FlexAPI\Model\Interfaces\Condition;
use FlexAPI\Model\Module;
use FlexAPI\Model\Record;

class ListView
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

    public function setOrderByField($field) {
        $this->orderBy = $field;
    }

    public function setOrderDirection($direction) {
        $direction = strtolower($direction);

        $this->sortOrder = ($direction === 'desc' ? 'desc' : 'asc');
    }

    public function run() {
        $options = [];
        if(!empty($this->pagesize)) $options['limit'] = $this->pagesize;
        if(!empty($this->page)) $options['page'] = $this->page;
        if(!empty($this->fields)) $options['fields'] = $this->fields;
        if(!empty($this->condition)) $options['condition'] = $this->condition->getConditionsForApi();
        if(!empty($this->orderby)) $options['orderby'] = $this->orderby;
        if(!empty($this->sortorder)) $options['sortorder'] = $this->sortorder;

        $response = Client::getInstance()->request()->get('listing/list/'.$this->module->getModuleName(), $options);

        if(!is_array($response)) {
            throw new \Exception($response);
        }

        $listViewModel = new \FlexAPI\Model\ListView($this);

        /** @var Field[] $fields */
        $fields = [];
        foreach($response['headers'] as $header) {
            $field = new Field($header['fieldname'], $header['fieldtype']);
            $field->setLabel($header['fieldlabel']);
            $field->setUIType($header['uitype']);

            $fields[] = $field;
        }

        $listViewModel->setFields($fields);

        foreach($response['entries'] as $crmid => $entry) {
            $record = new Record($this->module, $crmid);
            $record->initData($entry);

            $listViewModel->addRecord($record);
        }

        return $listViewModel;
    }

}
