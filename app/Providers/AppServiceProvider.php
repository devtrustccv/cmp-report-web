<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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

        // @iguais(10) -> "==========" com tamanho fixo (para usar no INÍCIO de uma frase)
        Blade::directive('iguais', fn ($n) => "<?php echo str_repeat('=', (int) (" . ($n ?: '10') . ")); ?>");

        // @preencher -> "=====" até ao fim da linha atual. Usar SÓ no fim de um parágrafo (ver .preencher no layout)
        Blade::directive('preencher', fn () => '<span class="preencher">' . str_repeat('=', 300) . '</span>');

        if (! $this->app->environment('local')) {
            URL::forceScheme('https');
        }
    }
}
