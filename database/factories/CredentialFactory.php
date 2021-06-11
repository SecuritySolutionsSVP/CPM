<?php

namespace Database\Factories;

use App\Models\Credential;
use App\Models\CredentialGroup;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CredentialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var Credential
     */
    protected $model = Credential::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'credential_group_id' => CredentialGroup::factory(),
            'username' => $this->faker->userName,
            'password' => $this->faker->password(),
            'is_sensitive' => $this->faker->boolean(20),
            'password_last_updated_at' => Carbon::now()
        ];
    }
}
