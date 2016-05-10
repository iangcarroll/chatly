<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

$capsule = new Capsule();
$fs = new Filesystem();

if (getenv('DATABASE_URL')) {
    $url = parse_url(getenv('DATABASE_URL'));
    
    $capsule->addConnection([
        'driver'    => 'pgsql',
        'database'  => substr($url['path'], 1),
        'username'  => $url['user'],
        'password'  => $url['pass'],
        'host'      => $url['host'],
        'port'      => $url['port'],
        'charset'   => 'UTF8',
    ]);
} else {
    $directory = getenv('HOME').'/.chatly-data';
    
    $path = $directory.'/chatly.sqlite';
    
    if (!$fs->exists($directory)) {
        $fs->mkdir($directory);
    }

    if (!$fs->exists($path)) {
        try {
            $fs->touch($path);
        } catch (IOExceptionInterface $e) {
            throw new RuntimeException("Error creating a database at {$path}.");
        }
    }
    
    $capsule->addConnection([
      'driver'    => 'sqlite',
      'database'  => $path,
    ]);
}

$capsule->setAsGlobal();
$capsule->bootEloquent();
