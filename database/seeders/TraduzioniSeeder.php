<?php

namespace Database\Seeders;

use App\Models\Lingue;
use App\Models\Traduzioni;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TraduzioniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Percorso della cartella "lang"
        $lingue = base_path('lang');

        // Ottieni tutte le sottocartelle
        $tipiLingue = File::directories($lingue);

        // Scansiona le sottocartelle
        foreach ($tipiLingue as $lingua) {
            // Ottieni il percorso completo della sottocartella
            $linguaPath = $lingua;
            $abbreviazione = basename($lingua); 
            $lingua = Lingue::where('abbreviazione',$abbreviazione)->firstOrFail();
            if (!$lingua) {
                abort(404); // Salta se non trovi la lingua nel database
            }
            // Ottieni tutti i file nella sottocartella corrente
            $files = File::allFiles($linguaPath);
        
            // Scansiona i file nella sottocartella corrente
            foreach ($files as $file) {
                // Ottieni il percorso completo del file
                $filePath = $file->getPathname();

                // Controlla se il file è un file PHP
                if ($file->getExtension() === 'php') {
                    // Carica il file delle lingue
                    $traduzioni = require $filePath;

                    // Ad esempio, ottieni le chiavi e i valori per ogni traduzione
                    foreach ($traduzioni as $chiave => $valore) {
                        // Ora puoi eseguire l'inserimento nel database utilizzando i valori ottenuti dai file di lingua
                        Traduzioni::create([
                            'idLingua' => $lingua->idLingua,
                            'chiave' => $chiave,
                            'valore' => $valore,
                        ]);
                    }
                }
            }
        }
        
        
    }
}
