<?php
namespace App\Responder;

class HelpResponder extends Responder
{
  private $kernel;

  public function __construct()
  {
    $this->setHelp("Shows this list.");
    $this->setCommand("help");
    $this->kernel = new Kernel;
  }

  public function run($args)
  {
    $responders = $this->kernel->responders;
    $this->bufferedMessage($args["channel"], "*Chatly Help*" . PHP_EOL);
    $this->bufferedMessage($args["channel"], "*Invoke a command by typing \"" . getenv("BOT_NAME") .  ", <command>\" in public channels on Slack.*" . PHP_EOL);

    $commands = [];
    foreach ($responders as $responder) {
      $responder = new $responder;
      if (! $responder->getChannels() || in_array($args["channel"], $responder->getChannels())) {
        $commands[$responder->getCommand()] = $responder->getHelp();
      }
    }
    ksort($commands);
    foreach ($commands as $command => $help) {
      $this->bufferedMessage($args["channel"], "*" . $command . "*: ". $help . PHP_EOL);
    }
    $this->sendBufferedMessage($args["channel"]);
  }
}
