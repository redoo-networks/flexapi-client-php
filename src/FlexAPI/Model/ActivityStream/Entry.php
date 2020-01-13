<?php


namespace FlexAPI\Model\ActivityStream;


class Entry
{
    private $type = 'DEFAULT';
    private $content = '';

    public function __construct($type, $content)
    {
        $this->type = $type;
        $this->content = $content;
    }

    public function getType() {
        return $this->type;
    }

    public function getContent() {
        return $this->type;
    }
}