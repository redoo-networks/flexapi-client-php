<?php
namespace FlexAPI\Model\Condition;

class Group
{
    private $conditions = array();
    private $glue = 'AND';

    public function addCondition($field, $operator, $value) {

        $this->conditions = array(
            $field,
            $operator,
            $value
        );

    }

    public function setGlue($glue) {
        $glue = strtolower($glue);

        $this->glue = ($glue =='and' ? 'and' : 'or');
    }

    public function getConditionsForApi() {
        return array_merge([
            'glue' => $this->glue,
            ],
            $this->conditions
        );
    }

}