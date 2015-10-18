<?php
namespace Service;

use Config;
use GuzzleHttp\Client;

class Giphy
{
    private $client;
    private $token;

    public function __construct()
    {
      $this->client = new Client([
          'timeout'  => 2.0,
      ]);
      $this->token = getenv("GIPHY_TOKEN");
    }

    public function get($query)
    {
      $r = json_decode($this->client->get("http://api.giphy.com/v1/gifs/search", [
          'query' => ["q" => $query, "api_key" => $this->token, "limit" => 50, "rating" => "r"]
      ])->getBody(), True);
      return $r["data"][array_rand($r["data"])]["images"]["fixed_height"]["url"];
    }
}
