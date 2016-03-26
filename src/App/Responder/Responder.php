<?php

namespace App\Responder;

use Service\Slack;

class Responder
{
    private $command;
    private $channels = [];
    private $help;
    private $buffer = [];

    public function getCommand()
    {
        return $this->command;
    }

    public function setCommand($command)
    {
        $this->command = $command;
    }

    public function getChannels()
    {
        return count($this->channels) == 0 ? false : $this->channels;
    }

    public function setChannels($channels)
    {
        $this->channels = $channels;
    }

    public function getHelp()
    {
        return isset($this->help) ? $this->help : false;
    }

    public function setHelp($text)
    {
        $this->help = $text;
    }

    public function sendMessage($channel, $message)
    {
        $slack = new Slack();

        return $slack->post($channel, $message);
    }

    public function bufferedMessage($channel, $message)
    {
        (isset($this->buffer[$channel]) ? $this->buffer[$channel] .= $message : $this->buffer[$channel] = $message);
    }

    public function sendBufferedMessage($channel)
    {
        $this->sendMessage($channel, $this->buffer[$channel]);
    }

    public function run($args)
    {
        $this->sendMessage($args['channel'], 'This responder has not been configured.');
    }
}
