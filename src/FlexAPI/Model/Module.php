<?php
namespace FlexAPI\Model;

class Module
{
    private $moduleName;

    public function __construct($moduleName) {
        $this->moduleName = $moduleName;
    }

    public function getRecord($crmid) {
        return new Record($this, $crmid);
    }

    public function getModuleName() {
        return $this->moduleName;
    }
}