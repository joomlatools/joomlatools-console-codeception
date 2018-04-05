<?php
namespace Page;

class LoginElements
{
    //front end

    public static $login_link = 'Log in';
    
    public static $username_field = 'input[name="username"]';

    public static $password_field = 'input[name="password"]';
    
    public static $login_button = 'Log in';

    public static $logout_button = 'button[type=submit]';

    public static $logout_link = 'Log out';
    
    public static $login_confirm = 'Hi %s';

    public static $logout_confirm = 'Log in';
    
    public static $login_error = 'Username and password do not match or you do not have an account yet.';

    public static $admin_password_field = 'input[name="passwd"]';

    public static $forgot_password_text = 'Forgot your password?';

    public static $forgot_email_input = 'input#jform_email';

    public static $forgot_confirm_text = 'An email has been sent to your email address.';

    public static $forgot_error_text = 'Reset password failed: Invalid email address';

    public static $forgot_submit_button = 'Submit';

    public static $forgot_email_subject = 'Your joomlatools password reset request';


    //admin side

    public static $admin_login_config = 'Control Panel';

    public static $admin_user_drop_down = "//ul[@class='nav nav-user pull-right']//li//a[@class='dropdown-toggle']";

    public static $admin_logout = "//li[@class='dropdown open']/ul[@class='dropdown-menu']//a[text() = 'Logout']";

    public static $admin_login = 'mod-login-username';
}
