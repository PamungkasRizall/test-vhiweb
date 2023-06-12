<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Rizal Pamungkas',
            'email' => 'pamungkas.rizall@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('123456')
        ];
    }
}
