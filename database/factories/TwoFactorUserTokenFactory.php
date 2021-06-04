<?php

namespace Database\Factories;

use App\Models\TwoFactorUserToken;
use Carbon\Carbon;
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
            'token' => $this->model::generateCode(6),
            'expiration' => Carbon::now()->addMinutes(5),
        ];
    }
}
