<?php

use App\Console\Commands\ProcessarAssinaturasPendentesCommand;
use App\Console\Commands\ProcessarRenovacaoAlvaraCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command(ProcessarAssinaturasPendentesCommand::class)
    ->everyFiveMinutes()
    ->withoutOverlapping();

Schedule::command(ProcessarRenovacaoAlvaraCommand::class)
    ->everyFiveMinutes()
    ->withoutOverlapping();
