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

namespace App\Migration;

use App\Model\Migration;
use App\Migration\Migration as MigrationMigration;
use Illuminate\Database\Capsule\Manager as Capsule;
use Symfony\Component\Console\Output\OutputInterface;

class Kernel
{
    public $migrations = [
        Message::class,
    ];

    public function migrate(OutputInterface $output)
    {
        if (! Capsule::schema()->hasTable("migrations")) {
          $migrations = new MigrationMigration;
          $migrations->up();
        }
        foreach ($this->migrations as $migration) {
          $migration = new $migration;
          if (count(Migration::where("name", get_class($migration))->get()) === 0) {
            $migration->up();
            $this->migrated($migration, $output);
          }
        }
    }

    private function migrated($class, $output)
    {
      $output->writeln("Migrated " . get_class($class) . ".");
      $migration = new Migration;
      $migration->name = get_class($class);
      $migration->save();
    }
}
