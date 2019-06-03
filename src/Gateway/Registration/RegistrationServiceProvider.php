<?php

namespace Deviate\Gateway\Registration;

use Illuminate\Support\ServiceProvider;

class RegistrationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
    }
}
