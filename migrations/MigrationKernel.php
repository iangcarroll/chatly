<?php

namespace App\Migration;

use App\Migration\Migration as MigrationMigration;
use App\Model\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;
use Symfony\Component\Console\Output\OutputInterface;

class MigrationKernel
{
    public $migrations = [
        Message::class,
    ];

    public function migrate(OutputInterface $output)
    {
        if (!Capsule::schema()->hasTable('migrations')) {
            $migrations = new MigrationMigration();
            
            $migrations->up();
        }
        
        foreach ($this->migrations as $migration) {
            $migration = new $migration();

            if (count(Migration::where('name', get_class($migration))->get()) === 0) {
                $migration->up();
                $this->migrated($migration, $output);
            }
        }
    }

    private function migrated($class, $output)
    {
        $class = get_class($class);
        
        $output->writeln('Migrated '.get_class($class).'.');
        
        Migration::create([
            'name' => $class,
        ]);
    }
}
