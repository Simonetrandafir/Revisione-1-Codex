<?php

namespace Database\Seeders;

use App\Models\Lingue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LingueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lingue = ['italiano', 'english', 'francese'];
        $abbreviazioni = ['it', 'en', 'fr']; // Aggiungi le abbreviazioni corrispondenti
        $locali = ['it_IT', 'en_US', 'fr_FR']; // Aggiungi i locali corrispondenti
        
        foreach ($lingue as $key => $lingua) {
            // Crea un nuovo record nel database utilizzando il modello Lingua
            Lingue::create(
                [
                    'nome'=>$lingua,
                    'abbreviazione'=>$abbreviazioni[$key],
                    'locale'=>$locali[$key],
                ]
            );
        }

    }
}
