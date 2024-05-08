<?php

namespace Database\Factories\v1;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RegistraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => 'ciro',
            'cognome' => 'esposito',
            'sesso' => null,
            'dataNascita' => '05-01-2022',
            'nazione' => '1',
            'citta' => $this->faker->word(),
            'provinciaNascita' => $this->faker->word(),
            'indirizzo' => $this->faker->word(),
            'civico' => $this->faker->word(),
            'cittadinanza' => $this->faker->word(),
            'codFiscale' =>null,
            'username' => $this->faker->word(),
            'email' => $this->faker->word(),
            'psw' => $this->faker->word(),
            'pswConfirm' => $this->faker->word(),
            'preferito' => null,
            'checkDati' => true,
        ];
    }
}
