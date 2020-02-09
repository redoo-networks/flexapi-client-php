<?php


namespace FlexAPI\Model;


use FlexAPI\Client;

class Document extends Record
{
    public function saveFile($filepath) {
        $params = array();
        if(!empty($this->accessBridgeId)) {
            $params['accessBridgeCrmId'] = $this->accessBridgeId;
        }

        file_put_contents($filepath,
            Client::getInstance()->request()->get(
               'documents/' . $this->crmid . '/content',
                $params,
                true
            )
        );

    }
}