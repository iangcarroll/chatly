<?php

namespace App\Command;

use App\Migration\Kernel as MigrationsKernel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Migrate extends Command
{
    private $kernel;

    protected function configure()
    {
        $this->setName('migrate')
         ->setDescription('Migrate the database.');

        $this->kernel = new MigrationsKernel();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Migrating database...');
        
        $this->kernel->migrate($output);
    }
}
