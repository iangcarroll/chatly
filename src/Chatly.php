<?php

use App\Command\Kernel as CommandKernel;
use Symfony\Component\Console\Application;

class Chatly extends Application
{
    public function load(CommandKernel $commands)
    {
        foreach ($commands->commands as $command) {
            $this->add(new $command());
        }
    }
}
