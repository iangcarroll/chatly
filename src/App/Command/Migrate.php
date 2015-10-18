<?php
namespace App\Command;

use App\Migration\Kernel as CommandKernel;
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
    $this->kernel = new CommandKernel;
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $output->writeln("Migrating database...");
    $this->kernel->migrate($output);
  }
}
