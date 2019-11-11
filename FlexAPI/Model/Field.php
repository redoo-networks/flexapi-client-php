<?php


namespace FlexAPI\Model;


class Field
{
    private $fieldname;
    private $fieldlabel;
    private $uitype;
    private $fieldtype;

    public function __construct($fieldname, $fieldtype = null)
    {
        $this->fieldname = $fieldname;
        $this->fieldtype = $fieldtype;
    }

    public function setLabel($label) {
        $this->fieldlabel = $label;
    }

    public function setUIType($uitype) {
        $this->uitype = $uitype;
    }

    public function setFieldtype($fieldtype) {
        $this->fieldtype = $fieldtype;
    }

    /** Getters **/

    public function getFieldname() {
        return $this->fieldname;
    }

    public function getLabel() {
        return $this->fieldlabel;
    }

    public function getUIType() {
        return $this->uitype;
    }

    public function getFieldtype() {
        return $this->fieldtype;
    }
}