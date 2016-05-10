<?php

date_default_timezone_set('America/Detroit');

/* Register our exception handler before everything else. */
$sentry = new Service\Sentry();
$sentry->registerHandler();

require __DIR__.'/database.php';

try {
    $dotenv = new Dotenv\Dotenv(__DIR__.'/../');
    $dotenv->load();
} catch (InvalidArgumentException $e) {
    die('You must create an .env file to run Chatly. See .env.example for an example.'.PHP_EOL);
}
