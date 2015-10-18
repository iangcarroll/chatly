<?php
// Copyright 2015 Certly, Inc.

// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at

//    http://www.apache.org/licenses/LICENSE-2.0

// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

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
