<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define os comandos Artisan customizados da aplicação.
     *
     * @var array<int, class-string>
     */
    protected $commands = [
        \App\Console\Commands\BackupDB::class,
        \App\Console\Commands\BackupServe::class
    ];

    /**
     * Define a programação dos comandos da aplicação.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('backup:serve')->dailyAt('15:30');
        $schedule->command('backup:database')->dailyAt('15:30');
    }

    /**
     * Registra os comandos Artisan.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
