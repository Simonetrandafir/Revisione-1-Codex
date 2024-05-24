<?php

namespace Database\Seeders;

use App\Models\Recapiti;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecapitiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Recapiti::create(
            [
                'idContatto'=>1,
                'idTipoRecapito'=>1,
                'recapito'=>'33369983844'
            ]
        );
        Recapiti::create(
            [
                'idContatto'=>1,
                'idTipoRecapito'=>3,
                'recapito'=>'00000000'
            ]
        );
        Recapiti::create(
            [
                'idContatto'=>1,
                'idTipoRecapito'=>2,
                'recapito'=>'05456165'
            ]
        );
    }
}
