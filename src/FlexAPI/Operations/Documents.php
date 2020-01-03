<?php


namespace FlexAPI\Operations;


use FlexAPI\Client;

class Documents
{
    public function getFolders() {
		$response = Client::getInstance()->request()->get('documents/folders');
		var_dump($response);

        return $response;
		
	}
	
    public function createDocument($filepath, $filename, $fields) {
        $content = file_get_contents($filepath);

		$params = array();
		$params['fields'] = $fields;
		$params['file'] = base64_encode($content);
		$params['filename'] = $filename;

		$response = Client::getInstance()->request()->post('documents/create', $params);

        return $response;
    }
	
    public function updateDocument($documentId, $filepath, $filename, $fields) {
        $content = file_get_contents($filepath);

		$params = array();
		$params['fields'] = $fields;
		$params['file'] = base64_encode($content);
		$params['filename'] = $filename;

		$response = Client::getInstance()->request()->post('documents/' . $documentId, $params);

        return $response;
    }

}