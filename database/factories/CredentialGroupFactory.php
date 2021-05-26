<?php

namespace Database\Factories;

use App\Models\CredentialGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class CredentialGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var CredentialGroup
     */
    protected $model = CredentialGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(8),
            'description' => $this->faker->text(30)
        ];
    }
}
