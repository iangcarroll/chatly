<?php

namespace App\Command;

class Kernel
{
    public $commands = [
        Migrate::class,
        Listen::class
    ];
}
