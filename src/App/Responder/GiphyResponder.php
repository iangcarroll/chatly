<?php
namespace App\Responder;

use Config;
use Service\Giphy;
use GuzzleHttp\Client;

class GiphyResponder extends Responder
{
  protected $giphy;

  public function __construct()
  {
    $this->setHelp("Fetch a GIF. (chatly, giphy star wars)");
    $this->setCommand("giphy");
    $this->giphy = new Giphy;
  }

  public function run($args)
  {
    $query = $args["raw"];
    array_shift($query);
    $query = implode($query);
    $giphy = new Giphy;
    $this->sendMessage($args["channel"], $giphy->get($query));
  }
}
