<?php

namespace Database\Seeders;

use App\Models\Configurazioni;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigurazioniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Configurazioni::create(["idConfigurazioni"=>1,"chiave"=>"maxLogErrati","valore"=>"5"]);
        Configurazioni::create(["idConfigurazioni"=>2,"chiave"=>"durataSfida","valore"=>"3000"]);
        Configurazioni::create(["idConfigurazioni"=>3,"chiave"=>"durataSessione","valore"=>" 43200"]);
        Configurazioni::create(["idConfigurazioni"=>4,"chiave"=>"storicoPSW","valore"=>"3"]);
        Configurazioni::create(["idConfigurazioni"=>5,"chiave"=>"scadenzaPsw","valore"=>"7776000"]);
        // Configurazioni::create(["idConfigurazioni"=>5,"chiave"=>"","valore"=>""]);
        // Configurazioni::create(["idConfigurazioni"=>6,"chiave"=>"","valore"=>""]);
    }
}
