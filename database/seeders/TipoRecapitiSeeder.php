<?php

namespace Database\Seeders;

use App\Models\TipoRecapiti;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoRecapitiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoRecapiti::create([
            'nome'=>'cellulare',
        ]);
        TipoRecapiti::create([
            'nome'=>'telefono',
        ]);
        TipoRecapiti::create([
            'nome'=>'fax',
        ]);
    }
}
