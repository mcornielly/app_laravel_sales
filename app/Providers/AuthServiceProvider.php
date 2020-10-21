<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        'App\Divisa' => 'App\Policies\DivisaPolicy',
        'App\Category' => 'App\Policies\CategoryPolicy',
        'App\Product' => 'App\Policies\ProductPolicy',
        'App\Income' => 'App\Policies\IncomePolicy',
        'App\Provider' => 'App\Policies\ProviderPolicy',
        'App\Sale' => 'App\Policies\SalePolicy',
        'App\Customer' => 'App\Policies\CustomerPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
