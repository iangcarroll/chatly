<?php

namespace App\Responder;

class Kernel extends ResponderKernel
{
    public $responders = [
        HelpResponder::class,
        FactResponder::class,
        GiphyResponder::class,
    ];
}
