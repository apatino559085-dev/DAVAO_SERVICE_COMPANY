<?php

namespace App\Providers;

use App\Models\JobPost;
use App\Policies\JobPostPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        Gate::policy(JobPost::class, JobPostPolicy::class);

        // Share pending applications count with all views
        view()->composer('*', function ($view) {
            if (auth()->check() && (auth()->user()->isHR() || auth()->user()->isAdmin())) {
                $count = \App\Models\Application::where('is_archived', false)
                    ->where('status', 'pending')
                    ->count();
                $view->with('pending_applications_count', $count);
            }
        });
    }
}
