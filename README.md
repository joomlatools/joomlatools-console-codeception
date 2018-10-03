Joomla Console - Codeception Plugin
===============================

This is a simple wrapper command for Codeception projects used in conjuction with the [Joomlatools Console](https://www.joomlatools.com/developer/tools/console/).

The plugin adds a `codeception:bootstrap` command which you can use to
quickly create accceptance tests for any Joomla site.

Installation
------------

* Run the following command

	`$ joomla plugin:install joomlatools/console-codeception`

* Verify that the plugin is available:

	`$ joomla plugin:list`

* You can now create a new Codeception project by:

	`$ joomla codeception:bootstrap sitename`

* For available options, run

   `$ joomla help Codeception:bootstrap`
   
* If you would like to hook up an existing Joomlatools Project/ component simply use the `--www option`
  
   `$ joomla codeception:bootstrap logman --www=/home/vagrant/Projects`

Requirements
------------

It is assumed you have composer already installed. We recommend installing Codeception globally on the host machine:

`composer global require "codeception/codeception:*"`

also for our mailcatcher integration:

`composer global require flow/jsonpath`

Codeception makes use of the chromedriver: 

`brew install chromedriver`

You can verify correct install by:

`chromedriver --help`

Finally we just need selenium-server:

`brew install selenium-server-standalone`

You can verfiy correct install by:

`selenium-server --help`

If this has installed with no problems simply open a new terminal window and

`selenium-server`

Navigate to your component or website folder and run:

`codecept run acceptance`

Increase the output from each test by appending `--debug`

`codecept run acceptance --debug`

And output variables from within the tests with codecept_debug($var) when running suite tests in debug mode.

## Contributing

This plugin is an open source, community-driven project. Contributions are welcome from everyone. We have [contributing guidelines](CONTRIBUTING.md) to help you get started.

## Contributors

See the list of [contributors](https://github.com/joomlatools/joomlatools-console-Codeception/contributors).

## License

This plugin is free and open-source software licensed under the [MPLv2 license](LICENSE.txt).

## Community

Keep track of development and community news.

* Follow [@joomlatoolsdev on Twitter](https://twitter.com/joomlatoolsdev)
* Join [joomlatools/dev on Gitter](http://gitter.im/joomlatools/dev)
* Read the [Joomlatools Developer Blog](https://www.joomlatools.com/developer/blog/)
* Subscribe to the [Joomlatools Developer Newsletter](https://www.joomlatools.com/developer/newsletter/)
