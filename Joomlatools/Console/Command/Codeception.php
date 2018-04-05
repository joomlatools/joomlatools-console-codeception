<?php
/**
 * @copyright	Copyright (C) 2007 - 2014 Johan Janssens and Timble CVBA. (http://www.timble.net)
 * @license		Mozilla Public License, version 2.0
 * @link		http://github.com/joomlatools/joomlatools-console-codeception for the canonical source repository
 */

namespace Joomlatools\Console\Command;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

use Joomlatools\Console\Command\Site\AbstractSite;

class Codeception extends AbstractSite
{
    protected static $files;

    protected $config;

    protected $dest;

    protected $tests;

    protected $tests_dest;

    protected function configure()
    {
        parent::configure();

        if (empty(self::$files)) {
            self::$files = self::getFilesPath();
        }

        $this
            ->setName('codeception:init')
            ->setDescription('Create a new codeception project for your site')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);


        $this->check($input, $output);

        $path               = self::$files;
        $this->config       = $path . DIRECTORY_SEPARATOR . 'codeception.yml';
        $this->tests        = $path . DIRECTORY_SEPARATOR . 'tests';
        $this->dest         = $this->target_dir . DIRECTORY_SEPARATOR;
        $this->tests_dest   = $this->dest . 'tests';

        //lets copy over the original files and folders
        `cp $this->config $this->dest`;

        `cp -R $this->tests $this->tests_dest`;

        //now that we've coped the files there are acceptance test configs that need to be updated
        $host_name = $this->site . ".test";
        $db_name = "sites_" . $this->site;

        $update_configs = Yaml::parse(file_get_contents($this->tests_dest . DIRECTORY_SEPARATOR . 'acceptance.suite.yml'));
        $update_configs['modules']['config']['WebDriver']['url'] = $host_name;
        $update_configs['modules']['config']['Db']['dsn'] = sprintf($update_configs['modules']['config']['Db']['dsn'], $db_name);
        $yaml = Yaml::dump($update_configs, 5);

        file_put_contents($this->target_dir . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'acceptance.suite.yml', $yaml);

        $output->writeLn('<info>Codeception project created. On your host machine navigate to the site project folder and run:</info>');
        $output->writeLn('codecept run acceptance');
    }

    protected function check(InputInterface $input, OutputInterface $output)
    {
        $configuration = $this->dest . "codeception.yml";
        $tests = $this->tests_dest;

        if (file_exists($configuration))
        {
            `rm $configuration`;
            //throw new \RuntimeException('Codeception is already installed');
            //return;
        }

        if (is_dir($tests))
        {

            `rm -R $tests`;
            //throw new \RuntimeException('Codeception tests folder already exists');
            //return;
        }
    }

    public static function getFilesPath()
    {
        $path = dirname(__DIR__);

        if (!empty($path)) {
            return $path . DIRECTORY_SEPARATOR . 'Files';
        }
    }
}