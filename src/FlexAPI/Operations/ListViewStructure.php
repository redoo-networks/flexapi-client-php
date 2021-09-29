<?php


namespace FlexAPI\Operations;


use FlexAPI\Client;
use FlexAPI\Model\Field;
use FlexAPI\Model\Interfaces\Condition;
use FlexAPI\Model\Module;
use FlexAPI\Model\Record;

class ListViewStructure
{
    private $module;
    private $customviewId = 'all';

    public function __construct(Module $module)
    {
        $this->module = $module;
    }

    public function setCustomViewId($customviewId) {
        $this->customviewId = $customviewId;
    }


    public function run() {
        $response = Client::getInstance()->request()->get('listing/structure/'.$this->module->getModuleName() . '/' . $this->customviewId);

        if(!is_array($response)) {
            throw new \Exception($response);
        }

        $listViewStructureModel = new \FlexAPI\Model\ListViewStructure($this, $response);


        return $listViewStructureModel;
    }

}
