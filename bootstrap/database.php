<?php
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Symfony\Component\Filesystem\Filesystem;
use Illuminate\Database\Capsule\Manager as Capsule;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

$capsule = new Capsule;
$fs = new Filesystem();
$path = getenv("HOME") . '/.chatly-data/chatly.sqlite';
if (! $fs->exists(getenv("HOME") . '/.chatly-data')) {
  $fs->mkdir(getenv("HOME") . '/.chatly-data');
}
if (! $fs->exists($path)) {
  try {
      $fs->touch($path);
  } catch (IOExceptionInterface $e) {
      throw new RuntimeException("Error creating a database at " . $pathh);
  }
}
$capsule->addConnection([
    'driver'    => 'sqlite',
    'database'  => $path
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();
