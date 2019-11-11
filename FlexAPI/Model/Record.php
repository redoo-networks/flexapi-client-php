<?php
namespace FlexAPI\Model;

use FlexxCustomerportal\Controller;

class Record
{
    /**
     * @var Module
     */
    private $module;

    /**
     * @var int
     */
    private $crmid;

    private $data = [];

    public function __construct(Module $module, $crmid)
    {
        $this->module = $module;
        $this->crmid = intval($crmid);
    }

    public function initData($data) {
        if(is_array($data) === false) {
            throw new \InvalidArgumentException('$data must be an array [field1:value1, field2:value2, ....]');
        }

        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData() {
        if(empty($this->data)) {
            $this->data = Controller::getAPIClient()->request()->get('records/' . $this->module->getModuleName() . '/' . $this->crmid);
        }

        return $this->data;
    }

    /**
     * @param $fieldname
     * @return mixed|null
     */
    public function get($fieldname) {
        if(empty($this->data)) $this->getData();

        return isset($this->data[$fieldname]) ? $this->data[$fieldname] : null;

    }

    public function has($fieldname, $notEmpty = false) {
        if(empty($this->data)) $this->getData();

        if($notEmpty === true) {
            return !empty($this->data[$fieldname]);
        } else {
            return isset($this->data[$fieldname]);
        }

    }

    public function getComments($onlyPublic = false) {
        $response = Controller::getAPIClient()->request()->
                get('records/comments/' . $this->module->getModuleName() . '/' . $this->crmid . ($onlyPublic ? '/public' : ''), array());

        $result = array();
        $commentModule = new Module('ModComments');
        foreach($response as $comment) {
            $record = new Record($commentModule, $comment['commentid']);
            $record->initData($comment);

            $result[] = $record;
        }

        return $result;
    }

    public function createComment($commentcontent) {
        Controller::getAPIClient()->request()->
                post('records/' . $this->crmid . '/comments', array(
                    'comment' => $commentcontent
        ));

    }

    /**
     * @param $fieldName
     * @param $moduleName
     * @return Record|null
     */
    public function getReferenceRecord($fieldName, $moduleName) {
        $value = $this->get($fieldName);

        if(!empty($value)) {
            $reference = new Record(new Module($moduleName), $value);

            return $reference;
        }

        return null;
    }
}