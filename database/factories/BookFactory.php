<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titolo'      => fake()->sentence(3), // Genera una frase di 3 parole
            'autore'      => fake()->name(),      // Genera un nome e cognome
            'anno'        => fake()->year(),      // Genera un anno casuale
            'genere'      => fake()->word(),      // Genera una parola singola
            'descrizione' => fake()->paragraph(), // Genera un paragrafo di testo
        ];
    }
}
