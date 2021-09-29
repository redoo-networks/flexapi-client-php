<?php
namespace FlexAPI\Model;

use FlexAPI\Client;

class Record
{
    /**
     * @var Module
     */
    protected $module;

    /**
     * @var int
     */
    protected $crmid;

    protected $data = [];

    protected $accessBridgeId = null;

    public function __construct(Module $module, $crmid)
    {
        $this->module = $module;

        if(is_numeric($crmid) === false) {
            $crmid = trim($crmid);

            if(preg_match('/^[0-9a-f]{8}\b-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-\b[0-9a-f]{12}$/', $crmid)) {
                $this->crmid = $crmid;
            }
        } else {
            $this->crmid = intval($crmid);
        }

    }

    public function getId() {
        return $this->crmid;
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
            $params = array();
            if(!empty($this->accessBridgeId)) {
                $params['accessBridgeCrmId'] = $this->accessBridgeId;
            }

            $this->data = Client::getInstance()->request()->get(
                'records/' . $this->module->getModuleName() . '/' . $this->crmid,
                $params
            );
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
        $response = Client::getInstance()->request()->
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
        Client::getInstance()->request()->
        post('records/' . $this->crmid . '/comments', array(
            'comment' => $commentcontent
        ));

    }

    public function createPublicComment($commentcontent) {
        Client::getInstance()->request()->
        post('records/' . $this->crmid . '/comments', array(
            'is_private' => 0,
            'comment' => $commentcontent,
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

    public function getRelatedRecords($relatedModule, $relationId = 0, $fields = array()) {
        if(is_array($relationId)) {
            $fields = $relationId;
            $relationId = 0;
        }

        if(empty($relationId)) {
            $url = sprintf('records/relations/%s/%s/%s',
                $this->module->getModuleName(),
                $this->getId(),
                $relatedModule
            );
        } else {
            $url = sprintf(
                'records/relations/%s/%s/%s/%d',
                $this->module->getModuleName(),
                $this->getId(), $relatedModule,
                $relationId
            );
        }

        $response = Client::getInstance()->request()->get($url, array('fields' => $fields));

        return $response;
    }

    public function setAccessBridge($accessBridgeCrmId) {
        $this->accessBridgeId = intval($accessBridgeCrmId);
    }

    public function createCustomerComment($commentcontent) {
        $params = array(
            'is_private' => 0,
            'current_customer_author' => true,
            'comment' => $commentcontent,
        );

        Client::getInstance()
            ->request()
            ->post('records/' . $this->crmid . '/comments', $params);

    }

    public function update($fields) {
        $params = array(
            'fields' => $fields,
        );

        Client::getInstance()
            ->request()
            ->post('records/' . $this->module->getModuleName() . '/' . $this->getId(), $params);
    }

    public function updateInventoryRecord($fields, $products, $groupTaxes) {
        $params = array(
            'fields' => $fields,
            'products' => $products,
            'group_taxes' => $groupTaxes
        );

        $response = Client::getInstance()
            ->request()
            ->post('records/update_inventory/' . $this->module->getModuleName() . '/' . $this->getId(), $params);

        return new Record($this, $response['id']);
    }

}
