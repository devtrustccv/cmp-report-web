<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

use Carbon\Carbon;

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
        Carbon::setLocale('pt');

        // Limites globais do PHP (APP_MEMORY_LIMIT / APP_MAX_EXECUTION_TIME no .env)
        ini_set('memory_limit', config('app.memory_limit'));
        set_time_limit(config('app.max_execution_time'));

        if (! $this->app->environment('local')) {
            URL::forceScheme('https');
        }
    }
}
