<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register IDE helper service provider in local environment
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Prevent lazy loading and silently discarding attributes in non-production environments
        Model::preventLazyLoading( ! $this->app->isProduction());
        Model::preventSilentlyDiscardingAttributes( ! $this->app->isProduction());

        // Log slow database queries based on the configured threshold
        $threshold = config('database.slow_query_threshold', 1000);
        assert(is_int($threshold) && $threshold > 0); // Ensure threshold is a positive integer

        DB::whenQueryingForLongerThan($threshold, function () use ($threshold): void {
            logger()->warning(
                'A database query took longer than '
                    . $threshold
                    . 'ms to execute.',
            );
        });
    }
}
