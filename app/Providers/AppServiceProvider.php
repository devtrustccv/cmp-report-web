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

        // @iguais -> "=====" fixo a negrito no INÍCIO de um parágrafo (nº em LinhaPreenchida::IGUAIS_INICIO)
        // @iguais(10) -> força outro número
        Blade::directive('iguais', fn ($n) => "<?php echo '<b class=\"iguais\">' . str_repeat('=', (int) (" . ($n ?: '\App\Http\Helpers\LinhaPreenchida::IGUAIS_INICIO') . ")) . '</b>'; ?>");

        // @preencher -> "=====" até ao fim da linha atual. Usar SÓ no fim de um parágrafo (ver .preencher no layout)
        Blade::directive('preencher', fn () => '<span class="preencher">' . str_repeat('=', 300) . '</span>');

        if (! $this->app->environment('local')) {
            URL::forceScheme('https');
        }
    }
}
