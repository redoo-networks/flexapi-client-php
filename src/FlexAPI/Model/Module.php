<?php
namespace FlexAPI\Model;

use FlexAPI\Client;

class Module
{
    private $moduleName;

    public function __construct($moduleName) {
        $this->moduleName = $moduleName;
    }

    public function getRecord($crmid) {

        if($this->moduleName !== 'Documents') {
            return new Record($this, $crmid);
        } else {
            return new Document($this, $crmid);
        }

    }

    public function getModuleName() {
        return $this->moduleName;
    }

    public function getFields($view = 'DetailView') {
        $fields = Client::getInstance()->request()->get('fields/get/' . $this->getModuleName() . '/' . $view);

        $result = array();
        foreach($fields as $blockLabel => $blockFields) {
            $block = array(
                'label' => $blockLabel,
                'fields' => [],
            );

            foreach($blockFields as $field) {
                $newField = new Field($field['name'], $field['type']);
                $newField->setLabel($field['label']);

                $newField->set('mandatory', $field['mandatory']);
                $newField->set('defaultvalue', $field['defaultvalue']);

                $block['fields'][] = $newField;
            }

            $result[] = $block;
        }

        return $result;
    }
}