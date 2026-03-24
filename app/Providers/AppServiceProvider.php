<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Borrowing;
use App\Policies\BorrowingPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register policies
        $this->registerPolicies();
    }

    /**
     * Register application policies.
     */
    protected function registerPolicies(): void
    {
        \Illuminate\Support\Facades\Gate::policy(Borrowing::class, BorrowingPolicy::class);
    }
}
