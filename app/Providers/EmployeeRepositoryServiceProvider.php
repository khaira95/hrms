<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EmployeeRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\EmployeeRepositoryInterface',
            'App\Repositories\EmployeeRepository'
        );
    }

   
}
