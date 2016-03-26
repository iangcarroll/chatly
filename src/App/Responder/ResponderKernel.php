<?php

namespace App\Responder;

class ResponderKernel
{
    public $responders = [
    HelpResponder::class,
  ];

    public function has($command, $channel)
    {
        $exists = in_array($command, $this->commands());

        if (!$exists) {
            return false;
        }
        $commands = $this->commands(true);
        $command = new $commands[$command]();
        if (!$command->getChannels()) {
            return true;
        } elseif (in_array($channel, $command->getChannels())) {
            return true;
        }

        return false;
    }

    public function responderForObject($command, $channel)
    {
        if ($this->has($command, $channel)) {
            $commands = $this->commands(true);

            return new $commands[$command]();
        }

        return false;
    }

    private function commands($text_in_key = false)
    {
        $commands = [];

        foreach ($this->responders as $responder) {
            $responder = new $responder();
            ($text_in_key ? $commands[$responder->getCommand()] = get_class($responder) : $commands[get_class($responder)] = $responder->getCommand());
        }

        return $commands;
    }
}
