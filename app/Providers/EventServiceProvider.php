<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider{
    protected $listen = [
        \Illuminate\Auth\Events\Login::class => [
            \App\Listeners\MergeCartAfterLogin::class,
        ],
    ];
    
}