<?php
namespace FlexAPI\Model\Base;

use FlexAPI\Model\Condition\Group;

class Condition implements \FlexAPI\Model\Interfaces\Condition
{
    /**
     * @var Group[]
     */
    private $groups = null;

    public function addGroup() {
        $group = new Group();
        $this->groups[] = $group;

        return $group;
    }

    public function getConditionsForApi() {
        $result = array();

        foreach($this->groups as $group) {
            $result[] = $group->getConditionsForApi();
        }

        return $result;
    }
}