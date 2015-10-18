<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap/app.php';

use App\Command\Kernel as CommandKernel;

$application = new Chatly("Chatly", "1.0");
$application->load(new CommandKernel);
$application->run();
