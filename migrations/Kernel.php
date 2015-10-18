<?php
namespace App\Migration;

use App\Model\Migration;
use App\Migration\MigrationKernel;
use App\Migration\Migration as MigrationMigration;
use Illuminate\Database\Capsule\Manager as Capsule;
use Symfony\Component\Console\Output\OutputInterface;

class Kernel extends MigrationKernel
{
    public $migrations = [
        Message::class,
    ];
}
