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

Please refer to the barebones-codeception repo for host machine requirements:
https://github.com/yiendos/barebones-codeception

However once you have bootstrapped your first website or project you can check your host machine requirements by running the following bash script:
https://github.com/yiendos/barebones-codeception/blob/master/check_host_machine_requirements.sh


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
 
 
## Temp install notes whilst the console command is not on packagist

The following console application loads relevant plugins:
https://github.com/joomlatools/joomlatools-console/blob/master/src/Joomlatools/Console/Application.php#L169

The plugin path is: 
`/home/vagrant/.joomlatools/console/plugins`


So we need to ammend the following file: `/home/vagrant/.joomlatools/console/plugins/composer.json` 

```
$ cat /home/vagrant/.joomlatools/console/plugins/composer.json
{
    "require": {
        "joomlatools/console-joomlatools": "^1.3",
        "joomlatools/console-capistrano": "^1.0"
    }
}
```

amend to: 
```
{
    "require": {
        "joomlatools/console-joomlatools": "^1.3",
        "joomlatools/console-capistrano": "^1.0",
        "joomlatools/console-codeception": "^1.0",
        "symfony/yaml": "3.3"
    }
}
```
and ensure that your new development plugin is symlinked here into the vendor folder `.joomlatools/console/plugins/vendor/joomlatools` 

```
ln -s /home/vagrant/Projects/joomlatools-console-codeception/ /home/vagrant/.joomlatools/console/plugins/vendor/joomlatools/console-codeception` 
```

Then you will need to update the following file `/home/vagrant/.joomlatools/console/plugins/vendor/composer/installed.json` 

Append the following information to the list of installed dependancies:

```
[
    ...

    {
        "name": "joomlatools/console-codeception",
        "version": "v1.0.2",
        "version_normalized": "1.0.2.0",
        "source": {
            "type": "git",
            "url": "https://github.com/joomlatools/joomlatools-console-codeception.git",
            "reference": "23be2998d80b0499c462f3b90b89e19f7bef20d0"
        },
        "dist": {
            "type": "zip",
            "url": "https://api.github.com/repos/joomlatools/joomlatools-console-codeception/zipball/23be2998d80b0499c462f3b90b89e19f7bef20d0",
            "reference": "23be2998d80b0499c462f3b90b89e19f7bef20d0",
            "shasum": ""
        },
        "time": "2015-11-30T15:56:08+00:00",
        "type": "joomlatools-console-plugin",
        "installation-source": "dist",
        "autoload": {
            "psr-0": {
                "Joomlatools\\": "/"
            }
        },
        "notification-url": "https://packagist.org/downloads/",
        "license": [
            "MPLv2"
        ],
        "authors": [
            {
                "name": "Joomlatools",
                "email": "info@joomlatools.com",
                "homepage": "https://www.joomlatools.com"
            }
        ],
        "description": "A simple wrapper to execute pre-configured codeception projects",
        "homepage": "https://github.com/joomlatools/joomlatools-console-codeception"
    }
]
```

Then instruct composer to dump the existing autoloader and generate a new one with our plugin installed: 

`cd /home/vagrant/.joomlatools/console/plugins/`

`composer dump-autoload`

Verify the development plugin has been found: 

`joomla plugin:list` 

Then a futher check the console command has been included