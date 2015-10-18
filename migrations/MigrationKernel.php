<?php
namespace App\Migration;

use App\Model\Migration;
use App\Migration\Migration as MigrationMigration;
use Illuminate\Database\Capsule\Manager as Capsule;
use Symfony\Component\Console\Output\OutputInterface;

class MigrationKernel
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
