<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;

class Migration
{
    public function up()
    {
        Capsule::schema()->create('migrations', function ($table) {
        $table->increments('id');
        $table->string('name');
        $table->timestamps();
    });
    }
}
