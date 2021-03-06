<?php
namespace FlexAPI\Utils;

use FlexAPI\Client;

class Request
{
    private $_VtigerURL = array();
    private $DEBUG = false;
    private $_LoginToken = null;

    private $customerToken = null;
    private $customerMode = false;

    private $uuidMode = false;

    private $secondTry = false;
    /**
     * @var Client
     */
    private $client = null;

    public function __construct($VtigerURL) {
        $this->_VtigerURL = trim($VtigerURL, '/').'/modules/FlexAPI/api.php';
    }

    public function setClient(Client $client) {
        $this->client = $client;
    }
    public function enableUUIDMode() {
        $this->uuidMode = true;
    }

    public function getLogintoken() {
        return $this->_LoginToken;
    }
    public function setLogintoken($token) {
        $this->_LoginToken = $token;
    }

    /**
     * @param $action
     * @param array $params
     * @param bool $directReturn
     * @return bool|string
     * @throws \Exception
     */
    public function post($action, $params = array(), $directReturn = false) {
        return $this->request('POST', $action, $params, $directReturn);
    }

    /**
     * @param $action
     * @param array $params
     * @param bool $directReturn
     * @return bool|string
     * @throws \Exception
     */
    public function get($action, $params = array(), $directReturn = false) {
        return $this->request('GET', $action, $params, $directReturn);
    }

    public function enableCustomerMode($token) {
        $this->customerMode = true;
        $this->customerToken = $token;
    }

    /**
     * @param $method
     * @param $action
     * @param array $params
     * @param bool $directReturn
     * @return bool|string
     * @throws \Exception
     */
    public function request($method, $action, $params = array(), $directReturn = false) {
        $curl = curl_init();

        if(is_array($action)) {
            $url = array_shift($action);
            $action = vsprintf($url, $action);
        }

        /* Prepare Params */
        $args = array();
        $args['params'] = $params;
        $args['method'] = $method;
        $args['action'] = $action;
        if(!empty($this->uuidMode)) {
            $args['enable-uuid'] = true;
        }

        if($this->customerMode === true) {
            $args['customer-mode'] = true;
            $args['customer-token'] = $this->customerToken;
        }

        if(!empty($this->_LoginToken)) {
            $args['user-token'] = sha1($this->_LoginToken);
        }

        $new = array();
        self::http_build_query_for_curl($args, $new);
        $args = $new;

        /* Do Request */

        curl_setopt($curl, 	CURLOPT_URL, $this->_VtigerURL);
        curl_setopt($curl, 	CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl,	CURLOPT_POST, count($args));
        curl_setopt($curl,	CURLOPT_POSTFIELDS, $args);
        /*
                if(!empty($options['cainfo'])) {
                    curl_setopt($curl, 	CURLOPT_CAINFO, $options['cainfo']);
                }
        */
        if($this->DEBUG === true) {
            curl_setopt($curl, 	CURLOPT_VERBOSE, 1);

            $verbose = fopen('php://temp', 'w+');
            curl_setopt($curl, CURLOPT_STDERR, $verbose);
        }
        /*
                if($userpwd !== false) {
                    curl_setopt($curl,	CURLOPT_USERPWD, $userpwd);
                }*/

        //curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, 	CURLOPT_FOLLOWLOCATION, true);

        $content = curl_exec($curl);

        if($this->DEBUG === true) {
            echo '<pre>';
            var_dump('URL: '.$this->_VtigerURL);
            var_dump('Action: '.strtoupper($method).' ' . $action);
            var_dump('Post Body: ', $args);
            echo 'Response:'.PHP_EOL;
            var_dump($content);

            rewind($verbose);
            $verboseLog = stream_get_contents($verbose);

            echo "Verbose information:\n<pre>", htmlspecialchars($verboseLog), "</pre>\n";
            echo '</pre>';
        }
        //$responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        /*
                if(!empty($responseCode) && !in_array($responseCode, $options['successcode'])) {
                    throw new \Exception('Error Code '.$responseCode.' - '.$content, $responseCode);
                }
        */
        curl_close($curl);

        if($directReturn === true) {
            return $content;
        }

        $result = json_decode($content, true);

        if(empty($result)) {
            var_dump($content);
        }

        if(!empty($result['data']['message'])) {
            echo 'Request error: ' . $result['data']['message'] . '<br/>';
        }

        if($result['result'] != 0 && $result['result'] !== 200) {

            switch($result['result']) {
                case 401:
                    return 'LOGIN';
                    break;
                case 403:
                    if($this->client->haveFallbackCustomerCredentials() && $this->secondTry === false) {
                        $this->secondTry = true;
                        $this->customerToken = '';

                        $this->customerToken = $this->client->doFallbackCustomerLogin();

                        return call_user_func_array(array($this, 'request'), func_get_args());
                    } else {
                        throw new \Exception('CUSTOMER-LOGIN', 403);
                    }
                    break;
                default:
                    throw new \Exception('Request error: '.$result['data'], $result['result']);
                    //echo 'Request error: ' . $result['result'] . '<br/>';

                    break;
            }
        }

        return $result['data'];
    }

    // Copyright: https://gist.github.com/mohsinrasool/50e0f43af626867dd05c
    public static function http_build_query_for_curl( $arrays, &$new = array(), $prefix = null ) {

        if ( is_object( $arrays ) ) {
            $arrays = get_object_vars( $arrays );
        }

        foreach ( $arrays AS $key => $value ) {
            $k = isset( $prefix ) ? $prefix . '[' . $key . ']' : $key;
            if ( is_array( $value ) OR is_object( $value )  ) {
                self::http_build_query_for_curl( $value, $new, $k );
            } else {
                $new[$k] = $value;
            }
        }
    }

}
