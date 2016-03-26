<?php

namespace App\Responder;

use GuzzleHttp\Client;

class FactResponder extends Responder
{
    public function __construct()
    {
        $this->setHelp('Fetch a fact about cats.');
        $this->setCommand('fact');
        $this->client = new Client(['timeout' => 2.0]);
    }

    public function run($args)
    {
        $r = $this->client->get('http://catfacts-api.appspot.com/api/facts');
        $r = json_decode($r->getBody(), true);
        $this->sendMessage($args['channel'], $r['facts'][0]);
    }
}
