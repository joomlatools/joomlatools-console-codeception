<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class DbHelper extends \Codeception\Module
{
    public function executeQuery($query)
    {
        $db = $this->getModule('Db');

        $updates = array($query);

        $db->driver->load($updates);
    }
}
