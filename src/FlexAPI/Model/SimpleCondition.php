<?php


namespace FlexAPI\Model;


use FlexAPI\Model\Base\Condition;

class SimpleCondition implements \FlexAPI\Model\Interfaces\Condition
{
    private $conditions = [];

    public function addCondition($field, $operator, $value) {

        $this->conditions = [
            $field,
            $operator,
            $value
        ];

    }

    public function getConditionsForApi() {
        return $this->conditions;
    }


}