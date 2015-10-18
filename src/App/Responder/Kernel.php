<?php
namespace App\Responder;

class Kernel
{
  public $responders = [
    HelpResponder::class,
    FactResponder::class,
    GiphyResponder::class
  ];

  public function has($command, $channel) {
    $exists = in_array($command, $this->commands());

    if (! $exists) {
      return False;
    }
    $commands = $this->commands(True);
    $command = new $commands[$command];
    if (! $command->getChannels()) {
      return True;
    } elseif (in_array($channel, $command->getChannels())) {
      return True;
    }

    return False;
  }

  public function responderForObject($command, $channel)
  {
    if ($this->has($command, $channel)) {
      $commands = $this->commands(True);
      return new $commands[$command];
    }

    return False;
  }


  private function commands($text_in_key = False)
  {
    $commands = [];

    foreach ($this->responders as $responder)
    {
      $responder = new $responder;
      ($text_in_key ? $commands[$responder->getCommand()] = get_class($responder) : $commands[get_class($responder)] = $responder->getCommand());
    }

    return $commands;
  }

}
