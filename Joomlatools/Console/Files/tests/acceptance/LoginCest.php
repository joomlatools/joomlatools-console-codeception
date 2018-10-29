<?php

use Page\LoginElements as LoginElements;

class LoginCest
{
    protected $settings;

    protected function _inject()
    {
        $config = \Codeception\Configuration::config();
        $acceptanceSettings = \Codeception\Configuration::suiteSettings('acceptance', $config);

        $this->settings = $acceptanceSettings;

        $this->site = $this->settings['modules']['config']['WebDriver']['site'];
    }

    public function _before(\Step\Acceptance\Login $I, \Codeception\Scenario $scenario)
    {
        $I->deleteEmails();

        if ($scenario->current('env') == 'travis')
        {
            $this->site = $this->settings['env']['travis']['modules']['config']['WebDriver']['travis_site'];
        }
    }

    public function _after(\Step\Acceptance\Login $I)
    {

    }

    public function LoginFrontEnd(\Step\Acceptance\Login $I, \Codeception\Scenario $scenario)
    {
        $I->LoginFrontEnd();

        $I->wait(2);

        $I->LogoutFrontEnd();
    }

    public function ForgottenPassword(\Step\Acceptance\Login $I, \Codeception\Scenario $scenario)
    {
        $I->RequestPasswordReminder();

        $I->checkEmails(array('email' => "<user@example.com>", 'search' => 'subject', 'value' => sprintf(LoginElements::$forgot_email_subject, $this->site)));
    }

    public function LoginAdminEnd(\Step\Acceptance\Login $I, \Codeception\Scenario $scenario)
    {
        $I->LoginAdminEnd();

        $I->wait(2);

        $I->LogoutAdminEnd();
    }
}
