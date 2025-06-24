<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Note;
use Carbon\Carbon;

class SupprimerVieillesNotes extends Command
{
    protected $signature = 'notes:supprimer-vieilles';

    protected $description = 'Supprime les notes supprimées depuis plus de 30 jours';

    public function handle()
    {
        $limite = Carbon::now()->subDays(30);

        $nombre = Note::onlyTrashed()
            ->where('deleted_at', '<=', $limite)
            ->forceDelete();

        $this->info("✅ $nombre notes supprimées définitivement.");
    }
}
