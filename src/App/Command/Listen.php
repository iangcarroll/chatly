<?php

namespace App\Command;

use Service\Queue;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Listen extends Command
{
    private $kernel;

    protected function configure()
    {
        $this->setName('listen')
         ->setDescription('Listen for messages from SQS.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Listening...');
        
        $queue = new Queue();
        
        while (true) {
            $queue->work();
        }
    }
}
