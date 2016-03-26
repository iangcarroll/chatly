<?php

namespace Service;

use GuzzleHttp\Client;

class Slack
{
    private $client;
    private $url;

    public function __construct()
    {
        $this->client = new Client([
          'timeout'  => 2.0,
      ]);
        $this->url = getenv('SLACK_WEBHOOK_URL');
    }

    public function post($channel, $message)
    {
        return $this->client->request('POST', $this->url, [
        'json'        => ['text' => $message, 'channel' => '#'.$channel, 'parse' => 'full'],
        'http_errors' => false,
      ]);
    }
}
