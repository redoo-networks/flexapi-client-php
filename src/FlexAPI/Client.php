<?php
namespace FlexAPI;

use FlexAPI\Exception\LoginException;
use FlexAPI\Manager\ActionsManager;
use FlexAPI\Manager\ActivityStreamManager;
use FlexAPI\Manager\CloudFileManager;
use FlexAPI\Manager\CustomerportalManager;
use FlexAPI\Manager\ExportManager;
use FlexAPI\Manager\FieldManager;
use FlexAPI\Manager\HomeManager;
use FlexAPI\Manager\ListingManager;
use FlexAPI\Manager\ModuleManager;
use FlexAPI\Manager\RecordManager;
use FlexAPI\Manager\SearchManager;
use FlexAPI\Manager\MenuManager;
use FlexAPI\Utils\Request;

class Client
{

    /**
     * @var Request
     */
    private $_Request = null;

    /**
     * @var Client
     */
    private static $instance = null;

    public static function connect($vtigerURL) {
        self::$instance = new self($vtigerURL);

        return self::$instance;
    }

    /**
     * @return Client
     */
    public static function getInstance() {
        return self::$instance;
    }

    /**
     * Client constructor.
     *
     * @param $VtigerURL
     */
    private function __construct($VtigerURL) {
        $this->_Request = new Request($VtigerURL);
    }

    public function setLogintoken($token) {
        $this->_Request->setLogintoken($token);
    }

    public function forget_password($username, $email) {
        $response = $this->_Request->post('login/forget_password', array('username' => $username, 'email' => $email));

        var_dump($response);
    }

    /**
     * @param $username
     * @param $password
     * @throws LoginException
     */
    public function login($username, $password) {
        $response = $this->_Request->post('login/login', array('username' => $username, 'password' => $password));

        if(isset($response['token'])) {
            $this->setLogintoken($response['token']);
        } else {
            throw new LoginException();
        }
    }

    public function enableCustomerMode($customerToken) {
        $this->_Request->enableCustomerMode($customerToken);
    }

    public function loginCustomer($usernameEmail, $password) {

        $response = $this->_Request->post(
            'customerportal/login',
            array(
                'email' => $usernameEmail,
                'password' => $password
            )
        );

        return $response['token'];
    }

    public function loginCustomerByKey($usernameEmail, $customerKey) {

        $response = $this->_Request->post(
            'customerportal/login',
            array(
                'email' => $usernameEmail,
                'key' => $customerKey
            )
        );
        var_dump($response);

        return $response['token'];
    }

    public function create_offline_token($token) {
        $this->_Request->get('login/offline_token', array('token' => $token));
    }

    /**
     * @return Request
     */
    public function request() {
        return $this->_Request;
    }

    public function restrictContactsMode($contactId) {
        $this->_Request->setViewMode('Contacts', $contactId);
    }

    public function restrictAccountsMode($accountId) {
        $this->_Request->setViewMode('Accounts', $accountId);
    }

}
