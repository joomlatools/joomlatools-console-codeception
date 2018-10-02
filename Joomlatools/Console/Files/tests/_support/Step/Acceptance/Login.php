<?php
namespace Step\Acceptance;

use Page\LoginElements as LoginElements;

class Login extends \WebGuy
{
    protected $_defaults = array(
        'username'          => 'user',
        'email'             => 'user@example.com',
        'password'          => 'user',
        'admin_username'    => 'admin',
        'admin_password'    => 'admin'
    );

    public function LoginFrontEnd($customisation = array())
    {
        $config = (object) array_merge($this->_defaults, $customisation);

        $I = $this;
        $I->amOnPage('/');

        $I->amGoingTo('Login as ' . $config->username);

        $I->fillField(LoginElements::$username_field, $config->username);
        $I->fillField(LoginElements::$password_field, $config->password);
        $I->click(LoginElements::$login_button);

        $I->see(sprintf(LoginElements::$login_confirm, $config->username));
        $I->dontSee(LoginElements::$login_error);
        $I->expect('To be logged in now');

        $I->amOnPage('/');
    }

    public function LogoutFrontEnd($customisation = array())
    {
        $config = (object) array_merge($this->_defaults, $customisation);
        
        $I = $this;
        $I->amGoingTo('Logout now');
        $I->click(LoginElements::$logout_link);
        $I->see(LoginElements::$login_link);
        $I->expect('To be logged out now');
    }

    public function LoginAdminEnd($customisation = array())
    {
        $config = (object) array_merge($this->_defaults, $customisation);

        $I = $this;
        $I->amOnPage('/administrator');
        $I->amGoingTo('Login in now');
        $I->fillField(LoginElements::$username_field, $config->admin_username);
        $I->fillField(LoginElements::$admin_password_field, $config->admin_password);
        $I->click(LoginElements::$login_button);

        $I->see(LoginElements::$admin_login_config);
        $I->dontSee(LoginElements::$login_button);

        $I->expect('To be logged into the admin side now');
    }

    public function LogoutAdminEnd($customisation = array())
    {
        $config = (object) array_merge($this->_defaults, $customisation);

        $I = $this;
        $I->amOnPage('administrator/');
        $I->amGoingTo('Log out now');
        $I->click(['xpath' => LoginElements::$admin_user_drop_down]);
        $I->waitForElement(['xpath' => LoginElements::$admin_logout]);
        $I->click(['xpath' => LoginElements::$admin_logout]);
        $I->waitForElement(['id' => LoginElements::$admin_login]);
        $I->waitForText('Log in');
    }

    public function RequestPasswordReminder($customisation = array())
    {
        $config = (object) array_merge($this->_defaults, $customisation);

        $I = $this;

        $I->amOnPage('/');
        $I->click(LoginElements::$forgot_password_text);
        $I->fillField('input#jform_email', $config->email);
        $I->click(LoginElements::$forgot_submit_button);
        $I->see(LoginElements::$forgot_confirm_text);
        $I->dontSee(LoginElements::$forgot_error_text);

        $I->expect('A forgotten email to be sent');
    }
}