<?php

namespace Database\Seeders;

use App\Models\Contatti;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContattiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contatti::create(
            [
                'idStato'=>1,
                'nome'=>'Simone',
                'cognome'=>'Trandafir',
                'sesso'=>'1',
                'codFiscale'=>'GFGFHNDN869DG',
                'cittadinanza'=>'Italiana',
                'idNazione'=>1,
                'citta'=>'Domicella',
                'provincia'=>'Avellino',
                'dataNascita'=>new \DateTime('2024-05-18 15:30:00'),
            ]
        );
        Contatti::create(
            [
                'idStato'=>1,
                'nome'=>'Pinco',
                'cognome'=>'Pallo',
                'cittadinanza'=>'italiana',
                'idNazione'=>1,
            ]
        );
        // Contatti::create(
        //     [
        //         'idStato'=>1,
        //         'nome'=>'test',
        //         'cognome'=>'test',
        //         'cittadinanza'=>'italiana',
        //         'idNazione'=>1,
        //     ]
        // );
    }
}
