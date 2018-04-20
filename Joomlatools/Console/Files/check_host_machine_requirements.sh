#!/usr/bin/env bash

#https://github.com/fideloper/Vaprobash/blob/master/scripts/composer.sh
#various bash scripts lifted from here
RED="\033[1;31m"
GREEN='\033[0;32m'
YELLOW="\033[1;33m"
BLUE="\033[1;34m"
END="\033[0m"

echo "${YELLOW}Checking you system for required software${END}"

#Does composer exist 
composer -v > /dev/null 2>&1
COMPOSER_IS_INSTALLED=$?

# True, if composer is not installed
if [[ $COMPOSER_IS_INSTALLED -ne 0 ]]; then
    echo "${RED}*********WARNING***********${END}"
    echo "Composer not installed:"
    echo "We recommend installing composer globally\n"
    echo "${BLUE}https://getcomposer.org/doc/00-intro.md#globally${END}"
    exit 0
else
    echo "${GREEN}Composer installed${END}"
fi

#Does codecept exist globally on the machine
composer global show | grep "codeception" >/dev/null 2>&1
CODECEPT_IS_INSTALLED=$?

# True, if codeception is not installed
if [[ $CODECEPT_IS_INSTALLED -ne 0 ]]; then
    echo "${RED}*********WARNING***********${END}"
    echo "Codeception not installed"
    echo "We recommend installing codeception on your host machine globally\n\n"
    echo "$ composer global require codeception/codeception"
    exit 0
else
    echo "${GREEN}Codeception installed${END}"
fi

#Does brew exist
brew -v > /dev/null 2>&1
BREW_IS_INSTALLED=$?

# True, if brew is not installed
if [[ $BREW_IS_INSTALLED -ne 0 ]]; then
    echo "${RED}*********WARNING***********${END}"
    echo "Brew not installed"
    echo "Brew is the recommended way to install both Chromedriver and Selenium Standalone Server\n"
    echo "${BLUE}https://brew.sh/${END}"
    exit 0
else
    echo "${GREEN}Brew installed${END}"
fi

brew list --versions | grep "chromedriver" > /dev/null 2>&1
CHROME_IS_INSTALLED=$?

# True, if brew chromedriver is not installed
if [[ $CHROME_IS_INSTALLED -ne 0 ]]; then
    echo "\n${RED}*********WARNING***********${END}"
    echo "Chromedrive not installed via Brew"
    echo "We recommend installing ChromeDriver via Brew:\n\n"
    echo "brew install chromedriver"
    exit 0
else
    echo "${GREEN}Brew Chromedriver installed${END}"
fi

brew list --versions | grep "selenium-server-standalone" > /dev/null 2>&1
SELENIUM_IS_INSTALLED=$?

# True, if brew selenium is not installed
if [[ $SELENIUM_IS_INSTALLED -ne 0 ]]; then
    echo "\n${RED}*********WARNING***********${END}"
    echo "Selenium not installed via Brew"
    echo "We recommend installing Selenium via Brew:"
    echo "brew install selenium-server-standalone"
    exit 0
else
    echo "${GREEN}Brew Selenium installed${END}"
fi

echo "\n${GREEN}*********SUCCESS***********${END}"
echo "${GREEN}You system is configured for codeception!${END}"

echo "\n${YELLOW}Next here are some aliases for you to create...${END}\n"

echo "alias joomlatoolsTunnel='ssh -f vagrant@33.33.33.71 -L 3306:127.0.0.1:3306 -N'\n"
echo "${YELLOW}This will allow you to remote tunnel into the vagrant box database, essential for restoring databases back to a initial state${END}\n\n"

echo "alias run-selenium='selenium-server > /dev/null 2>&1'\n"
echo "${YELLOW}This will run the server in the background so you can continue in the same Terminal window${END}"
