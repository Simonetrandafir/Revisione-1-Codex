<?php

namespace Database\Seeders;

use App\Http\Controllers\Api\v1\AccediController;
use App\Models\ContattiAuth;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContattiAuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'simonetrandafir@hotmail.it';
        $username = 'Admin00';
        ContattiAuth::create([
            'idContatto' => 1,
            'username'=> AccediController::hash($username),
            'email' => AccediController::hash($email),
            'secretJWT' => '',
        ]);
        // $username = 'test@email.it';
        // ContattiAuth::create([
        //     'idContatto' => 3,
        //     'username' => AccediController::hash($username),
        //     'secretJWT' => '',
        // ]);
    }
}
