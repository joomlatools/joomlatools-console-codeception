<?php
namespace Helper;

use Flow\JSONPath\JSONPath AS JSONPath;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class MailCatcherHelper extends \Codeception\Module
{
    protected $_email_url = '';

    protected $_defaults = array(
        'search'    => 'subject',
        'value'     => 'Your textman password reset request'
    );

    public function _beforeSuite($settings = []){
        $this->_email_url = $this->config['email_url'];
    }

    public function deleteEmails()
    {
        $rest = $this->getModule('REST');

        $rest->sendDELETE($this->_email_url);
    }

    public function checkEmails($customisation = array())
    {
        $config = (object) array_merge($this->_defaults, $customisation);

        $rest = $this->getModule('REST');

        $rest->sendGET($this->_email_url);

        $path    = new JSONPath(json_decode($rest->grabResponse()));

        $results = $path->find("$.*.$config->search")->data();

        if (!in_array($config->value, $results)) {
            $this->fail('The requested email was not found');
        }
    }
}
