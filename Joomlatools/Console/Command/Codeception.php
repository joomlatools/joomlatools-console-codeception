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
    protected $paths;

    protected $config;

    protected $check_host_script;

    protected $dest;

    protected $tests;

    protected $tests_dest;

    protected function configure()
    {
        parent::configure();

        $this
            ->setName('codeception:bootstrap')
            ->setDescription('Create a new codeception project for your site')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $this->paths = $this->getFilePaths();

        $this->check($input, $output);

        $output->writeln("<info>Downloading barebones codeception</info>");

        $this->cloneCodeception();

        $output->writeLn("<info>Configuring codeception</info>");

        $this->configureCodeception();

        $output->writeLn("<info>Finalising installation");

        $this->finalise($input, $output);
    }
    
    protected function cloneCodeception()
    {
        $paths = $this->paths;

        exec("git clone https://github.com/yiendos/barebones-codeception.git $paths->tmp");

        `cp $paths->config $paths->dest`;
        `cp -R $paths->tests $paths->tests_dest`;
        `cp $paths->check_host_script $paths->dest`;
    }

    protected function configureCodeception()
    {
        $host_name = $this->site . ".test";
        $db_name = "sites_" . $this->site;

        $update_configs = Yaml::parse(file_get_contents($this->paths->tests_dest . DIRECTORY_SEPARATOR . 'acceptance.suite.yml'));

        $update_configs['modules']['config']['SiteName'] = "$this->site";
        $update_configs['modules']['config']['WebDriver']['url'] = "http://" . $host_name;
        $update_configs['modules']['config']['Db']['dsn'] = str_replace('sites_joomlatools', $db_name, $update_configs['modules']['config']['Db']['dsn']);

        $yaml = Yaml::dump($update_configs, 5);

        file_put_contents($this->target_dir . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'acceptance.suite.yml', $yaml);
    }

    protected function finalise(InputInterface $input, OutputInterface $output)
    {
        $paths = $this->paths;
        //now lets remove the /tmp files
        `rm -R -f $paths->tmp`;

        $output->writeLn('<info>Codeception project created.</info>');
        $output->writeLn('<comment>We suggested you run the following bash script, as this will check your host machine to see you are set up correctly for codeception tests:</comment>');
        $output->writeLn( 'sh www' . DIRECTORY_SEPARATOR . $this->site . DIRECTORY_SEPARATOR . "check_host_machine_requirements.sh");

        $output->writeLn('<comment>After that you can run your tests at any time:</comment>');
        $output->writeLn('codecept run acceptance');
    }

    protected function check(InputInterface $input, OutputInterface $output)
    {
        $configuration = $this->paths->dest . "codeception.yml";
        $tests = $this->paths->tests_dest;

        if (file_exists($configuration))
        {
            `rm $configuration`;
            //throw new \RuntimeException('Codeception is already installed');
            //return;
        }

        if (is_dir($tests))
        {
            `rm -R -f $tests`;
            //throw new \RuntimeException('Codeception tests folder already exists');
            //return;
        }
    }

    protected function getFilePaths()
    {
        $path = dirname(__DIR__);

        if (!empty($path))
        {
            $path .= DIRECTORY_SEPARATOR;

            $tmp    = $path . "tmp" . DIRECTORY_SEPARATOR . "barebones-codception" . DIRECTORY_SEPARATOR;
            $dest   = $this->target_dir . DIRECTORY_SEPARATOR;

            $paths = array(
                'tmp'               => $tmp,
                'config'            => $tmp . 'codeception.yml',
                'tests'             => $tmp . 'tests',
                'check_host_script' => $tmp . 'check_host_machine_requirements.sh',
                'dest'              => $dest,
                'tests_dest'        => $dest . 'tests'
            );

            return (object) $paths;
        }
    }
}