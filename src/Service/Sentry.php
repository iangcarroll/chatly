<?php
namespace Service;

use Config;
use GuzzleHttp\Client;

class Sentry
{
    private $client;
    private $dsn = 'https://2c672d1ac745470ea7b034db6154f770:298b8294bd2a4095b90f0859c2be41d2@sentry.certly.io/4';

    public function __construct()
    {
      $this->client = new \Raven_Client($this->dsn);
    }

    public function registerHandler()
    {
      $error_handler = new \Raven_ErrorHandler($this->client);
      $error_handler->registerExceptionHandler();
      $error_handler->registerErrorHandler();
      $error_handler->registerShutdownFunction();
    }
}
