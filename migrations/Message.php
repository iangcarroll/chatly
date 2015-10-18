<?php
namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;

class Message
{
  public function up()
  {
    Capsule::schema()->create('messages', function($table)
    {
        $table->increments('id');
        $table->string('text');
        $table->string('user');
        $table->string('channel');
        $table->timestamps();
    });
  }
}
