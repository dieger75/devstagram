<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // aqui se define los datos falsos.
        return [
            // Faker es una biblioteca que se utiliza para generar datos falsos de manera rápida y sencilla. En este caso, se utiliza para generar datos falsos para los posts, como el título, la descripción, la imagen y el id del usuario al que pertenece el post. Esto es útil para poblar la base de datos con datos de prueba y simular el comportamiento de la aplicación con datos reales.

            'titulo' => $this->faker->sentence(5), // se genera un título falso con el método sentence() de Faker, pasando el número de palabras que se quieren en el título (5). Esto es para simular que cada post tiene un título diferente.
            'descripcion' => $this->faker->sentence(20),
            'imagen' => $this->faker->uuid() . '.jpg', // se genera un nombre de imagen falso con el método uuid() de Faker, que crea un UUID, y se le añade la extensión .jpg para simular que cada post tiene una imagen diferente.
            'user_id' => $this->faker->randomElement([
                1, // se asigna el id del usuario 1 a algunos posts para simular que ese usuario tiene varios posts
                2, // se asigna el id del usuario 2 a algunos posts para simular que ese usuario tiene varios posts
                3, // se asigna el id del usuario 3 a algunos posts para simular que ese usuario tiene varios posts
                4, // se asigna el id del usuario 3 a algunos posts para simular que ese usuario tiene varios posts
            ])
        ];
    }
}
