<?php

namespace Database\Factories;

use App\Models\TwoFactorCredentialToken;
use Illuminate\Database\Eloquent\Factories\Factory;

class TwoFactorCredentialTokenFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var TwoFactorCredentialToken
     */
    protected $model = TwoFactorCredentialToken::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'token' => $this->model->generateCode(6),
        ];
    }
}
