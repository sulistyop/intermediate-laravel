<?php

namespace App\Providers;

use App\Services\Impl\VisitServiceImpl;
use App\Services\VisitService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class VisitServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        VisitService::class => VisitServiceImpl::class
    ];

    public function provides()
    {
        return [VisitService::class];
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
