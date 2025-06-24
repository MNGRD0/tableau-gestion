<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Enregistre les commandes artisan personnalisées.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    /**
     * Planifie les tâches Artisan automatiquement.
     */
    protected function schedule(Schedule $schedule): void
    {
        // ⏰ Exécuter la suppression tous les jours à 2h du matin
        $schedule->command('notes:supprimer-vieilles')->dailyAt('02:00');
    }
}
