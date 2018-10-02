# README

This is designed to be a bare bones codeception acceptance suite, that should be plug and play for any Joomla component. All you need to do is run the following Joomlatools Console Command:

`joomla codeception:bootstrap codeception`

This will bring in the necessary site files, configure the suite and will test your host machine to see if it is correctly configured for codeception. 

`sh check_host_machine_requirements.sh`

## Codeception installation notes

First we need to get up and running:

`composer global require "codeception/codeception:*"`

also for mailcatcher integration:

`composer global require flow/jsonpath`

`brew install chromedriver`

You can verify correct install by:

`chromedriver --help`

`brew install selenium-server-standalone`

You can verfiy correct install by:

`selenium-server --help`

if this has installed with no problems simply open a new terminal window and

`selenium-server`

Navigate to your component project folder and run:

`codecept run acceptance`


## Notes for debugging tests 

Increase the output from each test by appending `--debug`: 

`codecept run acceptance --debug`

Output variables from within the tests with `codecept_debug($var)` when running suite tests in debug mode