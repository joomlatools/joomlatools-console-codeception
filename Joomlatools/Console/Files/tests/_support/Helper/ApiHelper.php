<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class ApiHelper extends \Codeception\Module
{
    /**
     * ability to clear cookies and history
     * @see Client::restart()
     */
    public function restartClient(){
        $this->getModule('PhpBrowser')->client->restart();
    }

    public function grabCSRF()
    {
        $cookie = $this->getModule('REST')->client->getCookieJar()->get('csrf_token')->getValue();

        return $cookie;
    }
}
