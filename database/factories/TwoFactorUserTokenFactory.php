<?php

namespace Database\Factories;

use App\Models\TwoFactorUserToken;
use Illuminate\Database\Eloquent\Factories\Factory;

class TwoFactorUserTokenFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var TwoFactorUserToken
     */
    protected $model = TwoFactorUserToken::class;

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
