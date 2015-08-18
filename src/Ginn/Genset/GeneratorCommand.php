<?php

namespace Ginn\Genset;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Filesystem\Filesystem;
use Ginn\Genset\GeneratorSet;

class GeneratorCommand extends Command
{
    private $GeneratorSet;

    public function __construct(GeneratorSet $generatorSet)
    {
        $this->generatorSet = $generatorSet;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('generate');
        $this->setDescription('Generator set for your Codeigniter');

        $this->addArgument('name', InputArgument::REQUIRED);
        $this->addOption('path', 'p', InputOption::VALUE_REQUIRED, '', getcwd());
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->generatorSet->create($input->getArgument('name'), $input->getOption('path'));
    }
}
